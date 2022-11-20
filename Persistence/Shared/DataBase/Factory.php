<?php 

namespace Persistence\Shared\DataBase;

use Persistence\App;
use Persistence\Shared\DataBase\Drivers\Mysql\MysqlFactory;
use Persistence\Shared\DataBase\Exceptions\UnknownDatabaseDriverException;
use Persistence\Shared\DataBase\Interfaces\DriverInterface;

class Factory {

    static public function createDriver(string $driver): DriverInterface
    {
        $db = null;

        if (preg_match("/mysql/",$driver))
        {
            $driver = new MysqlFactory(
                App::config("config.database.connections.mysql.database"),
                App::config("config.database.connections.mysql.port"),
                App::config("config.database.connections.mysql.username"),
                App::config("config.database.connections.mysql.password"),
                App::config("config.database.connections.mysql.host"),
            );
            $db = $driver->getDriver();
        }
        
        if(!$db)
            throw new UnknownDatabaseDriverException("Unknown Database driver");

        return $db;
    }
}