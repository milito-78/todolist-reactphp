<?php
namespace Core\DataBase;


use JetBrains\PhpStorm\Pure;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use React\MySQL\Io\LazyConnection;

class DBConnection
{
    /**
     * @var LazyConnection
     */
    private static LazyConnection $instance;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct()
    {
        global $container;

        self::$instance = $container
                ->get(
                    id: (string) "database"
                )->createLazyConnection(
                    $this->getUri()
                );
    }

    public static function getInstance(): LazyConnection
    {
        if (is_null(self::$instance)) {
            new self();
        }
        return self::$instance;
    }

    private function getUri(): string
    {
        return  config("database.connections.mysql.username") .
                ":" .
                config("database.connections.mysql.password") .
                "@".
                config("database.connections.mysql.host") .
                ":" .
                config("database.connections.mysql.port") .
                "/".
                config("database.connections.mysql.database");
    }

}