<?php


namespace Persistence\Shared\DataBase\Drivers\Mysql;


use Core\DataBase\Interfaces\DriverInterface;
use Core\DataBase\Interfaces\HandlerInterface;
use React\MySQL\Factory as Mysql;

class MysqlHandler implements HandlerInterface
{
    private string $username;
    private string $password;
    private string $host;
    private string $port;
    private string $database;
    private Mysql $connection;

    public function __construct(Mysql $mysql,string $database,string $port,string $username,string $password,string $host)
    {
        $this->database     = $database;
        $this->port         = $port;
        $this->username     = $username;
        $this->password     = $password;
        $this->host         = $host;
        $this->connection   = $mysql;
    }

    public function getDriver(): DriverInterface
    {
        return new MysqlDriver( $this->connection->createLazyConnection( $this->getConfig() ) );
    }

    private function getConfig(): string
    {
        return  $this->username .
            ":" .
            $this->password .
            "@".
            $this->host .
            ":" .
            $this->port .
            "/".
            $this->database;
    }

}