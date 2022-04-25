<?php

namespace Core\DataBase;


use Core\DataBase\Exceptions\UnknownDatabaseConnectionException;
use Core\DataBase\Interfaces\DatabaseInterface;
use Core\DataBase\Interfaces\DriverInterface;
use React\Promise\PromiseInterface;

class Database implements DatabaseInterface
{
    private DriverInterface $driver;
    private static array $drivers = [];


    public function __construct(DriverInterface $driver, $name = "mysql")
    {
        $this->driver           = $driver;
        self::$drivers[$name]   = $driver;
    }

    public function connection(string $name): DatabaseInterface
    {
        global $container;

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

    public function query($query, array $params = []): PromiseInterface
    {
        return $this->driver->query($query,$params);
    }

    public function all(string $table, array $fields = ["*"]): PromiseInterface
    {
        return $this->driver->all($table,$fields);
    }

    public function create(string $table, array $data): PromiseInterface
    {
        return $this->driver->create($table,$data);
    }

    public function update(string $table, int $id, array $data): PromiseInterface
    {
        return $this->driver->update($table,$id,$data);

    }

    public function delete(string $table, int $id): PromiseInterface
    {
        return $this->driver->delete($table,$id);
    }

    public function find(string $table, int $id, array $fields = ["*"]): PromiseInterface
    {
        return $this->driver->find($table,$id,$fields);
    }

    public function findBy(string $table, string $field, string $value, array $fields = ["*"]): PromiseInterface
    {
        return $this->driver->findBy($table,$field,$value,$fields);
    }
}