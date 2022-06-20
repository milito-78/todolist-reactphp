<?php


namespace Core\Route;

/**
 * @method static void get($path , callable $function, array $middleware = [])
 * @method static void post($path , callable $function, array $middleware = [])
 * @method static void put($path , callable $function, array $middleware = [])
 * @method static void patch($path , callable $function, array $middleware = [])
 * @method static void delete($path , callable $function, array $middleware = [])
 * @method static void group($prefix , callable $function, array $middleware = [])
 * @method static void getRoutesMiddleware()
 *
 * @see \Core\Route\Router
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