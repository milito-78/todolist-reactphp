<?php
namespace Persistence\Shared\DataBase\Drivers\Mysql;

use Core\DataBase\Interfaces\DriverInterface;
use React\MySQL\ConnectionInterface;
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
        foreach ($params as $key => $param)
        {
            if ($param == "NULL")
                $params[$key] = null;
        }
        return $this->instance->query($query,array_values($params));
    }

}