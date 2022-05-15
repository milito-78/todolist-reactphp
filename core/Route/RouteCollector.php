<?php
namespace Core\Route;

use Core\DI\DependencyResolverInterface;
use Core\Exceptions\MethodNotAllowedException;
use Core\Exceptions\NotFoundException;
// use FastRoute\Dispatcher\GroupCountBased;
use Core\Route\Dispatcher\GroupCountBased;
use FastRoute\RouteCollector as FastCollector;
use LogicException;
use Psr\Http\Message\ServerRequestInterface;


final class RouteCollector{

    private GroupCountBased $dispatch;
    private DependencyResolverInterface $resolver;

    public function __construct(FastCollector $collector,DependencyResolverInterface $diResolver)
    {
        $this->dispatch = new GroupCountBased($collector->getData());
        $this->resolver = $diResolver;
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

        return $this->findController($classes->middleware);
    }

    private function execController($request, $controller , $params, $middlewares)
    {
        if (is_array($controller) )
        {
            if(isset($controller["controller"]))
            {
                $action     = $controller["action"];
                $controller = $this->resolver->make($controller["controller"]);
                $response   = $controller->{$action}($request,...$params);
            }
            else if (isset($controller["invoke"]))
            {
                $controller = $this->resolver->make($controller["controller"]);
                $response   = $controller($request,...$params);
            }
        }
        else
            $response = $controller($request,...$params);

        return $response;
    }
}