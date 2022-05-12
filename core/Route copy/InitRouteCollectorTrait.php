<?php


namespace Core\Route;

use FastRoute\RouteCollector;

trait InitRouteCollectorTrait
{
    static protected RouteCollector $router;
    public static function init(RouteCollector $router)
    {
        self::$router = $router;
    }
    public static function getCollector(): RouteCollector
    {
        return self::$router;
    }

}