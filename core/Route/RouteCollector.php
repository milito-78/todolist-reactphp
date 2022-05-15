<?php
namespace Core\Route;

use Core\DI\DependencyResolverInterface;
use Core\Exceptions\MethodNotAllowedException;
use Core\Exceptions\NotFoundException;
// use FastRoute\Dispatcher\GroupCountBased;
use Core\Route\Dispatcher\GroupCountBased;
use Exception;
use FastRoute\RouteCollector as FastCollector;
use League\Container\DefinitionContainerInterface;
use LogicException;
use Psr\Http\Message\ServerRequestInterface;


final class RouteCollector{

    private GroupCountBased $dispatch;
    private DependencyResolverInterface $resolver;
    private DefinitionContainerInterface $container;
    private $middlewares_pool = [];
    private $controllers_pool = [];
    public function __construct(FastCollector $collector,DependencyResolverInterface $diResolver,DefinitionContainerInterface $container)
    {
        $this->dispatch     = new GroupCountBased($collector->getData());
        $this->resolver     = $diResolver;
        $this->container    = $container;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $route = $this->dispatch->dispatch(
            $request->getMethod(), $request->getUri()->getPath()
        );

        switch ($route[0])
        {
            case \FastRoute\Dispatcher::NOT_FOUND:
                throw new NotFoundException("Route Not Found",404);
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $method     = $route[1][0];
                $req_method =  $request->getMethod();
                throw new MethodNotAllowedException("Method '$req_method' does not supported. Supported method is '$method' ",405);
            case \FastRoute\Dispatcher::FOUND:
                $params     = array_values($route[2]);
                $controller = $this->findController($route[1]);
                $response   = $this->execController($request, $controller, $params, $route[3]??[]);

                return $response;
        }

        throw new LogicException("wrong");
    }

    private function findController($classes)
    {
        if (is_array($classes))
        {
            return ["controller" => $classes[0], "action" => $classes[1]];
        }
        else if ($classes instanceof \Closure)
        {
            return $classes;
        }
        elseif(is_string($classes))
        {
            return ["invoke" => $classes];
        }
    }

    private function execController($request, $controller , $params, $middlewares)
    {
        if (is_array($controller) )
        {
            if(isset($controller["controller"]))
            {
                $action     = $controller["action"];
               
                if(!key_exists($controller["controller"],$this->controllers_pool))
                {
                    $controller = $this->resolver->make($name = $controller["controller"]);
                    $this->controllers_pool[$name] = $controller;
                }
                else
                {
                    $controller = $this->controllers_pool[$controller["controller"]];
                }

                if(count($middlewares))
                {
                    $response = $this->execMiddleware($request,$middlewares,$controller,$params,$action);
                }
                else
                    $response   = $controller->{$action}($request,...$params);
            }
            else if (isset($controller["invoke"]))
            {

                if(!key_exists($controller["invoke"],$this->controllers_pool))
                {
                    $controller = $this->resolver->make($name = $controller["invoke"]);
                    $this->controllers_pool[$name] = $controller;
                }
                else
                {
                    $controller = $this->controllers_pool[$controller["invoke"]];
                }
                
                if(count($middlewares))
                {
                    $response = $this->execMiddleware($request,$middlewares,$controller,$params);
                }
                else
                    $response   = $controller($request,...$params);
            }
        }
        else{
            if(count($middlewares))
            {
                $response = $this->execMiddleware($request,$middlewares,$controller,$params);
            }
            else
                $response   = $controller($request,...$params);
        }

        return $response;
    }

    private function execMiddleware(ServerRequestInterface $request, $middlewares, $controller,$route_params ,$action = null)
    {
        if(!count($middlewares))
        {
            
            return function(ServerRequestInterface $request) use($controller,$action,$route_params){
                if(!is_null($action)){
                    return $controller->{$action}($request,...$route_params);
                }else{
                    return $controller($request,...$route_params);
                }
            };
        }

        $next       = head($middlewares);
        $middleware = explode(":",$next);
        $next       = $middleware[0];
        $params     = [];

        if(count($middleware) == 2)
        {
            $params = explode(",",$middleware[1]);
        }

        if(key_exists($next,$this->middlewares_pool))
        {
            $next = $this->middlewares_pool[$next];
        }
        else
        {
            $next = $this->resolver->make($this->findMiddlewareFromConfig($next));
            $this->middlewares_pool[$middleware[0]] = $next;
        }
        $tail = tail($middlewares);

        return $next($request,$this->execMiddleware($request,$tail,$controller,$route_params ,$action),...$params);
    }

    private function findMiddlewareFromConfig($middleware){
        $middelwares = config("app.middlewares");
        
        if(key_exists($middleware,$middelwares)){
            return $middelwares[$middleware];
        }
        throw new Exception("Middleware called '$middleware' not found!");
    }
}