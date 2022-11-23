<?php 

namespace Infrastructure\Cache;

use Application\Interfaces\Infrastructure\Cache\CacheDriverInterface;
use Exception;
use Infrastructure\Cache\Driver\FileDriver;
use Infrastructure\Cache\Driver\RedisDriver;

class Factory{

    /**
     * createDriver function
     *
     * @param string $driver
     * @return CacheDriverInterface
     * @throws Exception
     */
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

        throw new Exception("Driver is invalid");
    }
}