<?php


namespace Core\DataBase;


use Core\DataBase\Exceptions\UnknownDatabaseConnectionException;
use Core\DataBase\Interfaces\DriverInterface;
use NilPortugues\Sql\QueryBuilder\Builder\GenericBuilder;
use NilPortugues\Sql\QueryBuilder\Manipulation\AbstractBaseQuery;
use NilPortugues\Sql\QueryBuilder\Syntax\OrderBy;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use React\MySQL\QueryResult;
use React\Promise\PromiseInterface;

class Builder implements BuilderInterface
{
    private DriverInterface $driver;
    private static array $drivers       = [];
    private string $table               = "";
    private ?GenericBuilder $builder    = null;

    private $query = null;

    public function __construct(DriverInterface $driver, $name = "mysql")
    {
        $this->driver           = $driver;
        self::$drivers[$name]   = $driver;
    }

    /**
     * @param string $name
     * @return BuilderInterface
     * @throws UnknownDatabaseConnectionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function connection(string $name): BuilderInterface
    {
        $container = container();
        if ($container->has($name))
        {
            if (isset(self::$drivers[$name]))
                $this->driver = self::$drivers[$name];
            else
            {
                self::$drivers[$name]   = $container->get($name);
                $this->driver           =  self::$drivers[$name];
            }
            return $this;
        }
        throw new UnknownDatabaseConnectionException("Database connection name like '" . $name . "' is undefined");
    }

    public function setTable(string $table) : BuilderInterface
    {
        $this->table = $table;
        return $this;
    }

    public function getTable(): string
    {
        return $this->table;
    }

    public function builder(): GenericBuilder
    {
        if (!$this->builder)
            return $this->builder = new GenericBuilder();

        return $this->builder;
    }

    public function select(array $columns = ["*"]): static
    {
        if ($this->query)
        {
            $this->query = $this
                ->query
                ->select()
                ->setTable($this->getTable())
                ->setColumns($columns);
        }
        else
            $this->query = $this
                            ->builder()
                            ->select()
                            ->setTable($this->getTable())
                            ->setColumns($columns);

        return $this;
    }

    public function get(array $columns = ["*"]) : PromiseInterface
    {
        if (!$this->query) {
            $this->query = $this
                ->builder()
                ->select()
                ->setTable($this->getTable())
                ->setColumns($columns);
        }
        $query  =  $this->builder()->write($this->query);
        $values =  $this->builder()->getValues();
        $this->reset();
        return $this->driver->query($query,$values)
                            ->then(function(QueryResult $result){
                                return $result->resultRows;
                            });
    }

    public function create(array $values): PromiseInterface
    {
        $query  = $this->builder()->insert($this->getTable(),$values);
        $sql    = $this->builder->write($query);
        $values = $this->builder->getValues();
        $this->reset();
        return $this->driver->query($sql,$values)
                            ->then(function(QueryResult $result) use ($values){
                                $values["id"] = $result->insertId;
                                return $values;
                            });
    }

    public function update(array $conditions,array $values): PromiseInterface
    {
        $query  = $this->builder()->update($this->getTable(),$values);
        $query = $query->where();
        foreach ($conditions as $key => $value){
            $query = $query->equals($key,$value);
        }
        $query  = $query->end();
        $sql    = $this->builder->write($query);
        $values = $this->builder->getValues();
        $this->reset();
        return $this->driver->query($sql,$values)
                            ->then(function(QueryResult $result){
                                return (bool)$result->affectedRows;
                            });
    }

    public function delete(array $conditions): PromiseInterface
    {
        $query  = $this->builder()->delete($this->getTable());
        $query = $query->where();
        foreach ($conditions as $key => $value){
            $query = $query->equals($key,$value);
        }
        $query  = $query->end();
        $sql    = $this->builder->write($query);
        $values = $this->builder->getValues();
        $this->reset();
        return $this->driver->query($sql,$values)
            ->then(function(QueryResult $result){
                return (bool)$result->affectedRows;
            });
    }

    public function find($id,$columns = ["*"]): PromiseInterface
    {
        $query = $this->select($columns)
            ->query
            ->where()
            ->equals("id" , $id)
            ->end()
            ->limit(1);

        $sql    = $this->builder->write($query);
        $values = $this->builder->getValues();
        $this->reset();
        return $this->driver->query($sql,$values)
            ->then(function(QueryResult $result){
                return $this->checkResultRow($result);
            });
    }

    public function findBy($column ,$value,$columns = ["*"]): PromiseInterface
    {
        $query = $this->select($columns)
            ->query
            ->where()
            ->equals($column , $value)
            ->end()
            ->limit(1);

        $sql    = $this->builder->write($query);
        $values = $this->builder->getValues();
        $this->reset();
        return $this->driver->query($sql,$values)
            ->then(function(QueryResult $result){
                return $this->checkResultRow($result);
            });
    }

    public function first(array $conditions = [],$columns = ["*"]): PromiseInterface
    {
        $query = $this->select($columns)->query;
        if (count($conditions)){
            $query = $query->where();
                foreach ($conditions as $key => $value)
                    $query = $query->equals($key,$value);
            $query->end();
        }
        $query->limit(1);

        $sql    = $this->builder->write($query);
        $values = $this->builder->getValues();
        $this->reset();
        return $this->driver->query($sql,$values)
            ->then(function(QueryResult $result){
                return $this->checkResultRow($result);
            });
    }

    public function last(array $conditions = [],$columns = ["*"]): PromiseInterface
    {
        $query = $this->select($columns)->query;
        if (count($conditions)){
            $query = $query->where();
            foreach ($conditions as $key => $value)
                $query = $query->equals($key,$value);
            $query->end();
        }
        $query
            ->orderBy("id",OrderBy::DESC)
            ->limit(1);

        $sql    = $this->builder->write($query);
        $values = $this->builder->getValues();
        $this->reset();
        return $this->driver->query($sql,$values)
            ->then(function(QueryResult $result){
                return $this->checkResultRow($result);
            });
    }

    public function query($query, array $params = []): PromiseInterface
    {
        return $this->driver->query($query,$params);
    }

    public function customQueryBuilder(AbstractBaseQuery $query): PromiseInterface
    {
        $sql    = $this->builder->write($query);
        $values = $this->builder->getValues();

        return $this->query($sql,$values);
    }

    private function reset()
    {
        $this->query    = null;
        $this->builder  = null;
    }

    private function checkResultRow(QueryResult $result){
        if (!@$result->resultRows[0])
            return null;
        return $result->resultRows[0];
    }
}