<?php

namespace Service\Shared\Route\Dispatcher;

use Service\Shared\Route\RouteFacade as Router;
use FastRoute\Dispatcher\GroupCountBased as FastGroupCountBased;

class GroupCountBased extends FastGroupCountBased
{
    private $staticRouteMiddlewares = [];
    private $dynamicRouteMiddlewares = [];

    public function __construct($data)
    {
        list($this->staticRouteMap, $this->variableRouteData) = $data;
        $this->groupRouteMiddlewares(Router::getRoutesMiddleware());
    }
    
    public function dispatch($httpMethod, $uri)
    {
        if (isset($this->staticRouteMap[$httpMethod][$uri])) {
            $handler = $this->staticRouteMap[$httpMethod][$uri];
            return [self::FOUND, $handler, [], $this->staticRouteMiddlewares[$httpMethod][$uri]];
        }

        $varRouteData = $this->variableRouteData;
        if (isset($varRouteData[$httpMethod])) {
            $result = $this->dispatchVariableRoute($varRouteData[$httpMethod], $uri);
            if ($result[0] === self::FOUND) {
                return $result;
            }
        }

        // For HEAD requests, attempt fallback to GET
        if ($httpMethod === 'HEAD') {
            if (isset($this->staticRouteMap['GET'][$uri])) {
                $handler = $this->staticRouteMap['GET'][$uri];
                return [self::FOUND, $handler, [], $this->staticRouteMiddlewares['GET'][$uri]];
            }
            if (isset($varRouteData['GET'])) {
                $result = $this->dispatchVariableRoute($varRouteData['GET'], $uri);
                if ($result[0] === self::FOUND) {
                    return $result;
                }
            }
        }

        // If nothing else matches, try fallback routes
        if (isset($this->staticRouteMap['*'][$uri])) {
            $handler = $this->staticRouteMap['*'][$uri];
            return [self::FOUND, $handler, []];
        }
        if (isset($varRouteData['*'])) {
            $result = $this->dispatchVariableRoute($varRouteData['*'], $uri);
            if ($result[0] === self::FOUND) {
                return $result;
            }
        }

        // Find allowed methods for this URI by matching against all other HTTP methods as well
        $allowedMethods = [];

        foreach ($this->staticRouteMap as $method => $uriMap) {
            if ($method !== $httpMethod && isset($uriMap[$uri])) {
                $allowedMethods[] = $method;
            }
        }

        foreach ($varRouteData as $method => $routeData) {
            if ($method === $httpMethod) {
                continue;
            }

            $result = $this->dispatchVariableRoute($routeData, $uri);
            if ($result[0] === self::FOUND) {
                $allowedMethods[] = $method;
            }
        }

        // If there are no allowed methods the route simply does not exist
        if ($allowedMethods) {
            return [self::METHOD_NOT_ALLOWED, $allowedMethods];
        }

        return [self::NOT_FOUND];
    }

    protected function dispatchVariableRoute($routeData, $uri)
    {
        foreach ($routeData as $data) {
            if (!preg_match($data['regex'], $uri, $matches)) {
                continue;
            }
            $count_matches = count($matches);

            list($handler, $varNames)   = $data['routeMap'][$count_matches];
            $middlewares                = $data['middlewareMap'][$count_matches];
            
            $vars = [];
            $i = 0;
            foreach ($varNames as $varName) {
                $vars[$varName] = $matches[++$i];
            }
            return [self::FOUND, $handler, $vars, $middlewares];
        }

        return [self::NOT_FOUND];
    }

    private function groupRouteMiddlewares($routes)
    {

        foreach($this->staticRouteMap as $method => $route)
        {
            $temp = isset($routes[$method]) ? $routes[$method] : [];
            foreach($route as $key => $handler){
                if(isset($temp[$key]))
                {
                    $this->staticRouteMiddlewares[$method][$key] = $temp[$key];
                    unset($routes[$method][$key]);
                }
            }
        }

        foreach($this->variableRouteData as $method => &$route)
        {
            $temp = isset($routes[$method]) ? $routes[$method] : [];

            foreach($route as &$data){
                foreach($temp as $uri => $middleware){
                    if (!preg_match($data['regex'], $uri, $matches)) {
                        continue;
                    }
                    $data["middlewareMap"][count($matches)] = $middleware;
                    $this->dynamicRouteMiddlewares[$method][count($matches)] = $middleware;
                }
            }
        }
    }
}
