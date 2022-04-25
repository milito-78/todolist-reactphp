<?php
namespace Core\Providers;


use Core\DataBase\Database;
use Core\DataBase\Drivers\Mysql\MysqlHandler;
use Core\DataBase\Exceptions\UnknownDatabaseDriverException;
use Core\DataBase\Interfaces\DatabaseInterface;
use Core\DataBase\Interfaces\DriverInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;
use React\EventLoop\Loop;
use React\MySQL\Factory as Mysql;

use League\Container\ServiceProvider\BootableServiceProviderInterface;


class AppServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    public function provides(string $id): bool
    {
        $services = [
            DatabaseInterface::class,
            Database::class,
            DriverInterface::class,
        ];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $this->getContainer()
            ->add(DatabaseInterface::class,function (){
                return new Database(
                    $this->getContainer()->get(DriverInterface::class),
                    config("database.default","mysql")
                );
            });


        if (config("database.default","mysql") == "mysql")
        {
            $mysql = new Mysql($this->getContainer()->get((string)"loop"));
            $handler = new MysqlHandler(
                $mysql,
                config("database.connections.mysql.database"),
                config("database.connections.mysql.port"),
                config("database.connections.mysql.username"),
                config("database.connections.mysql.password"),
                config("database.connections.mysql.host"),
            );
        }
        else
        {
            throw new UnknownDatabaseDriverException("Unknown Database driver");
        }

        $this->getContainer()->add(DriverInterface::class,$handler->getDriver());

    }

    public function boot(): void
    {
        $this->getContainer()
            ->add("loop",Loop::get());
    }
}