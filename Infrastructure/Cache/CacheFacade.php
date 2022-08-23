<?php

namespace Infrastructure\Cache;


use React\Promise\PromiseInterface;

/**
 * @method static Cache store($store)
 * @method static void set($key,$value=null,$expire=null)
 * @method static PromiseInterface get($key,$default = null)
 *
 *  * @see Cache
 */
class CacheFacade
{
    static private ?Cache $cache = null;

    public static function __callStatic($name, $arguments)
    {
        $exchange = self::getOrCreateFacade();
        if (method_exists($exchange,$name)){
            return $exchange->{$name}(...$arguments);
        }
        throw new \Exception("Method not exists in Cache class",500);
    }

    public static function getOrCreateFacade(): Cache
    {
        if (!self::$cache)
            return self::$cache = new Cache();
        return self::$cache;
    }
}