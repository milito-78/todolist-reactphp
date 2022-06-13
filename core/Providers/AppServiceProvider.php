<?php
namespace Core\Providers;


use Core\DataBase\Builder;
use Core\DataBase\Drivers\Mysql\MysqlHandler;
use Core\DataBase\Exceptions\UnknownDatabaseDriverException;
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
            DriverInterface::class,
            Builder::class
        ];

        return in_array($id, $services);
    }

    public function register(): void
    {
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

        $this->getContainer()->add(Builder::class)
                            ->addArgument(DriverInterface::class)
                            ->addArgument(config("database.default","mysql"));
    }

    public function boot(): void
    {
        $this->getContainer()
            ->add("loop",Loop::get());
    }
}