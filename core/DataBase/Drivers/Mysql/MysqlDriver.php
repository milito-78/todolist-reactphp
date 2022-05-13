<?php
namespace Core\DataBase\Drivers\Mysql;

use Core\DataBase\Interfaces\DriverInterface;
use Core\DataBase\Interfaces\HandlerInterface;
use React\MySQL\ConnectionInterface;
use React\MySQL\QueryResult;
use React\Promise\PromiseInterface;

class MysqlDriver implements DriverInterface
{
    /**
     * @var ConnectionInterface
     */
    private ConnectionInterface $instance;

    public function __construct(ConnectionInterface $connection)
    {
        $this->instance = $connection;
    }

    public function query($query, array $params = []): PromiseInterface
    {
        return $this->instance->query($query,$params);
    }

    public function all(string $table,array $fields = ["*"]): PromiseInterface
    {
        return $this->instance->query("SELECT ". implode(",",$fields) ." FROM " . $table)
                    ->then(function(QueryResult $result){
                        return $result->resultRows;
                    });
    }

    public function create(string $table, array $data): PromiseInterface
    {
        $fields = array_keys($data);
        $values = array_values($data);
        $sql =  "INSERT INTO " . $table  .
                " (". implode(",",$fields) .") ".
                " VALUES (". implode(",",array_fill(0,count($fields),"?")) .")";

        return $this->instance->query($sql,$values)
                    ->then(function(QueryResult $result) use ($data){
                        $data["id"] = $result->insertId;
                        return $data;
                    });
    }

    public function update(string $table, int $id, array $data): PromiseInterface
    {
        $fields = array_keys($data);
        $values = array_values($data);
        foreach ($fields as $index => $field) {
            $fields[$index] = $field . " = ?";
        }

        $sql =  "UPDATE " . $table  .
                " SET ". implode(",",$fields) .
                " WHERE id = " . $id;

        return $this->instance->query($sql,$values)
                    ->then(function(QueryResult $result){
                        return (bool)$result->affectedRows;
                    }); 
    }

    public function delete(string $table, int $id): PromiseInterface
    {
        $sql =  "DELETE FROM " . $table . " WHERE id = ?";
        return $this->instance->query($sql,[$id])
                    ->then(function(QueryResult $result){
                        return (bool)$result->affectedRows;
                    });
    }

    public function find(string $table, int $id, array $fields = ["*"]): PromiseInterface
    {
        $sql =  "SELECT ".  implode(",",$fields) ." FROM " . $table ." WHERE id = ? LIMIT 1";
        return $this->instance->query($sql,[$id])
                    ->then(function(QueryResult $result){
                        return $this->checkResultRow($result);
                    });
    }

    public function findBy(string $table, string $field, string $value, array $fields = ["*"]): PromiseInterface
    {
        $sql =  "SELECT ".  implode(",",$fields) ." FROM " . $table ." WHERE ". $field ." = ? LIMIT 1";
        return $this->instance->query($sql,[$value])
                    ->then(function(QueryResult $result){
                        return $this->checkResultRow($result);
                    });
    }

    public function checkResultRow(QueryResult $result){
        if (!@$result->resultRows[0])
            return null;
        return $result->resultRows[0];
    }
}