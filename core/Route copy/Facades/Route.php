<?php


namespace Core\Route\Facades;

/**
 * @method static get($path , callable $function, array $middleware = [])
 * @method static post($path , callable $function, array $middleware = [])
 * @method static put($path , callable $function, array $middleware = [])
 * @method static patch($path , callable $function, array $middleware = [])
 * @method static delete($path , callable $function, array $middleware = [])
 * @method static group($prefix , callable $function, array $middleware = [])
 *
 * @see \Core\Route\Route
 */

class Route
{
    static private ?\Core\Route\Route $route = null;

    public static function __callStatic($name, $arguments)
    {
        $response = self::getOrCreateFacade();
        if (method_exists($response,$name)){
            return $response->{$name}(...$arguments);
        }

        throw new \Exception("Method not exists in Route class",500);
    }


    private static function getOrCreateFacade(): \Core\Route\Route
    {
        if (!self::$route)
            return self::$route = new \Core\Route\Route();
        return self::$route;
    }

}