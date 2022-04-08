<?php

namespace Core\Route;

use Core\Route\Middleware\MiddlewareTrait;

class Route
{
    use InitRouteCollectorTrait , MiddlewareTrait;

    static private string $uri = "";


    public function GET($path , callable $function, array $middleware = [])
    {
        self::makeRoute('get',$path , $function,$middleware);
    }


    public function POST($path , callable $function, array $middleware = [])
    {
        self::makeRoute('post',$path , $function,$middleware);
    }

    public function PUT($path , callable $function, array $middleware = [])
    {
        self::makeRoute('put',$path , $function,$middleware);
    }


    public function PATCH($path , callable $function, array $middleware = [])
    {
        self::makeRoute('patch',$path , $function,$middleware);
    }


    public function DELETE($path , callable $function, array $middleware = [])
    {
        self::makeRoute('delete',$path , $function,$middleware);
    }


    public function GROUP($prefix , callable $function, array $middleware = [])
    {
        $previousGroupPrefix = self::$uri;

        self::$uri = $previousGroupPrefix . static::uriSlashCheck($prefix);


        $prev_middleware = static::$middlewares;

        self::$middlewares = array_merge(self::$middlewares , $middleware);

        // routes inside group
        $function();

        static::$middleware = $prev_middleware;
        self::$uri = $previousGroupPrefix;
    }


    public static function __callStatic($method , $arguments)
    {
        $method = strtoupper($method);

        return (new static)->$method(...$arguments);
    }

    public static function uriSlashCheck($path)
    {
        if (strlen($path) == 0 || $path == '/') {
            if (self::$uri == '')
                return '/';
            return '';
        }

        if (substr($path , 0,1) != '/')
            $path =  '/' . $path;
        if (substr($path,-1) == '/')
            $path = substr($path,0,-1);

        return $path;
    }


    public static function makeRoute($type,$path,$function , $middleware)
    {
        $path = self::$uri . static::uriSlashCheck($path);
        $prev_middleware    = static::$middleware;
        $prev_middlewares   = static::$middlewares;

        if (!static::$middleware)
        {
            static::$middleware = $function;
        }

        $middleware = array_merge( self::$middlewares, $middleware);

        foreach ($middleware as $middle)
        {
            $constructor = explode(':',$middle);
            $params = isset($constructor[1]) ? explode(',',$constructor[1]): [];

            $name = $constructor[0];
            static::$middleware = new $name(static::$middleware,...$params);
        }

        self::$router->{$type}($path,static::$middleware);

        static::$middleware = $prev_middleware;
        static::$middlewares = $prev_middlewares;
    }

}