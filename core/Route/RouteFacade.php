<?php


namespace Core\Route;

/**
 * @method static get($path , callable $function, array $middleware = [])
 * @method static post($path , callable $function, array $middleware = [])
 * @method static put($path , callable $function, array $middleware = [])
 * @method static patch($path , callable $function, array $middleware = [])
 * @method static delete($path , callable $function, array $middleware = [])
 * @method static group($prefix , callable $function, array $middleware = [])
 * @method static getRoutesMiddleware()
 *
 * @see \Core\Route\Route
 */

use FastRoute\RouteCollector;

class RouteFacade
{
    static private ?Router $router = null;

    public static function __callStatic($name, $arguments)
    {
        $response = self::getOrCreateFacade();
        if (method_exists($response,$name))
        {
            return $response->{$name}(...$arguments);
        }

        throw new \Exception("Method not exists in Route class",500);
    }


    private static function getOrCreateFacade(): Router
    {
        if (!self::$router)
        {
            global $container;
            return self::$router = new Router($container->get(RouteCollector::class));
        }

        return self::$router;
    }

}