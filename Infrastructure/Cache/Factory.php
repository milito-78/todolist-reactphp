<?php 

namespace Infrastructure\Cache;

use Application\Interfaces\Infrastructure\Cache\CacheDriverInterface;
use Core\Cache\Driver\FileDriver;
use Core\Cache\Driver\RedisDriver;

class Factory{

    static public function createDriver(string $driver): CacheDriverInterface
    {
        if (preg_match("/redis/",$driver))
        {
            return new RedisDriver();
        }

        if (preg_match("/file/",$driver))
        {
            return new FileDriver();
        }
    }
}