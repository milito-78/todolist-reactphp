<?php

namespace Infrastructure\Cache\Facade;

use BadMethodCallException;
use Infrastructure\Cache\Cache as CacheBase;
use React\Promise\PromiseInterface;

/**
 * @method static Cache store($store)
 * @method static void set($key,$value=null,$expire=null)
 * @method static PromiseInterface get($key,$default = null)
 *
 *  * @see CacheBase
 */
class Cache
{
    static private ?CacheBase $cache = null;

    public static function __callStatic($name, $arguments)
    {
        $exchange = self::getOrCreateFacade();
        if (method_exists($exchange,$name)){
            return $exchange->{$name}(...$arguments);
        }
        throw new BadMethodCallException("Method not exists in Cache class");
    }

    public static function getOrCreateFacade(): CacheBase
    {
        if (!self::$cache)
            return self::$cache = new CacheBase();
        return self::$cache;
    }
}