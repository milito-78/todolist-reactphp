<?php

namespace Core\Route;

use FastRoute\RouteCollector;

class Router
{
    static private string $uri = "";

    private RouteCollector $routeCollector;
    private $route_middlewares = [];
    private $middlewares = [];


    public function __construct(RouteCollector $router)
    {
        $this->routeCollector = $router;
    }

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
        $previousGroupPrefix    = self::$uri;
        self::$uri              = $previousGroupPrefix . $this->uriSlashCheck($prefix);
        $prev_middlewares       = $this->middlewares;
        $this->middlewares      = array_merge($this->middlewares,$middleware);
        
        // routes inside group
        $function();

        $this->middlewares      = $prev_middlewares;
        self::$uri              = $previousGroupPrefix;
    }

    private function uriSlashCheck($path)
    {
        if (strlen($path) == 0 || $path == '/') {
            if (self::$uri == '')
                return '/';
            return '';
        }

        var_dump(" ssss " . $path . " " . self::$uri . ' -- ' . substr(self::$uri , 0,-1));

        if (substr(self::$uri ,-1) == '/' && substr($path , 0,1) == '/')
        {
            $path =  substr($path , 1);
        }
        elseif (substr(self::$uri ,-1) != '/' && substr($path , 0,1) != '/')
        {
            $path =  '/' . $path;
        }


        if (substr($path,-1) == '/')
            $path = substr($path,0,-1);

        return $path;
    }

    private function makeRoute($type,$path,$function , $middleware)
    {
        $path               = self::$uri . $this->uriSlashCheck($path);

        $this->addMiddlewareToRoutes($type,$path,array_merge($this->middlewares,$middleware));

        $this->routeCollector->{$type}($path,$function);
    }

    private function addMiddlewareToRoutes($method,$path,$middleware)
    {
        $method = strtoupper($method);

        if(isset($this->route_middlewares[$method]))
        {
            $this->route_middlewares[$method][$path] = array_merge($this->route_middlewares[$method][$path]??[],$middleware);
        }
        else
        {
            $this->route_middlewares[$method] = [$path => $middleware];
        }
    }

    public function getRoutesMiddleware(){
        return $this->route_middlewares;
    }

}