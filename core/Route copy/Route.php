<?php

namespace Core\Route;

use Core\Route\Middleware\MiddlewareTrait;

class Route
{
    use InitRouteCollectorTrait , MiddlewareTrait;
    static public $route_middlewares = [];

    static private string $uri = "";

    public function get($path , $function, array $middleware = [])
    {
        $this->makeRoute('get',$path , $function,$middleware);
    }


    public function post($path , $function, array $middleware = [])
    {
        $this->makeRoute('post',$path , $function,$middleware);
    }

    public function put($path , $function, array $middleware = [])
    {
        $this->makeRoute('put',$path , $function,$middleware);
    }


    public function patch($path , $function, array $middleware = [])
    {
        $this->makeRoute('patch',$path , $function,$middleware);
    }


    public function delete($path , $function, array $middleware = [])
    {
        $this->makeRoute('delete',$path , $function,$middleware);
    }


    public function group($prefix , callable $function, array $middleware = [])
    {
        $previousGroupPrefix = self::$uri;
        self::$uri          = $previousGroupPrefix . $this->uriSlashCheck($prefix);

        $prev_middlewares   = static::$middlewares;
        self::$middlewares  = array_merge(self::$middlewares , $middleware);

        // routes inside group
        $function();

        self::$middlewares  = $prev_middlewares;
        self::$uri          = $previousGroupPrefix;
    }


    private function uriSlashCheck($path)
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


    private function makeRoute($type,$path,$function , $middleware)
    {
        global $container;

        $path               = self::$uri . $this->uriSlashCheck($path);
        $path_regex         = $path;
        $prev_middlewares   = static::$middlewares;

        $middlewares = array_merge( self::$middlewares, $middleware);

        foreach ($middlewares as $middle)
        {
            self::$route_middlewares[$path_regex][$type] = [$middle];

            $constructor = explode(':',$middle);

            $name = $constructor[0];
            //TODO use container for create middleware and store in container
            if(!$container->has($name))
            {
                $container->add($name,new $name());
            }
        }
        // Controller make invokeable
        self::$router->{$type}($path,$function);

        static::$middlewares = $prev_middlewares;
    }

}