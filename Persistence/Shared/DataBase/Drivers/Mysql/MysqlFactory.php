<?php


namespace Persistence\Shared\DataBase\Drivers\Mysql;


use Persistence\Shared\DataBase\Interfaces\DriverInterface;
use Persistence\Shared\DataBase\Interfaces\HandlerInterface;
use React\EventLoop\Loop;
use React\MySQL\Factory as Mysql;

class MysqlFactory implements HandlerInterface
{
    private string $username;
    private string $password;
    private string $host;
    private string $port;
    private string $database;
    private Mysql $connection;

    public function __construct(string $database,string $port,string $username,string $password,string $host)
    {
        $mysql = new Mysql(Loop::get());

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