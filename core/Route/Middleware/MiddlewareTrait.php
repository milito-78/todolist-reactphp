<?php

namespace Core\Route\Middleware;

trait MiddlewareTrait
{
    static private array $middlewares = [];

    /**
     * @var callable
     */
    static private  $middleware = null;

    static private array $alias = [];

    public static function alias($alias)
    {
         self::$alias = $alias;
         foreach ($alias as $key => $al)
         {
             class_alias( $al,$key);
         }
    }
}