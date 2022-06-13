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
        $query = preg_replace("/:\w+\d+/" ,"?",$query);
        return $this->instance->query($query,array_values($params));
    }

}