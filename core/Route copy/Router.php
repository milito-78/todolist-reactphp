<?php
namespace Core\Route;

use Core\Exceptions\MethodNotAllowedException;
use Core\Exceptions\NotFoundException;
use FastRoute\Dispatcher\GroupCountBased;
use FastRoute\RouteCollector;
use LogicException;
use Psr\Http\Message\ServerRequestInterface;
use ReflectionException;


final class Router{

    use ValidationTrait;

    private GroupCountBased $dispatch;

    public function __construct(RouteCollector $collector)
    {
        $this->dispatch = new GroupCountBased($collector->getData());
    }

    /**
     * @throws ReflectionException
     */
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
                $params = array_values($route[2]);

                $request    = $this->checkRequestInstance($route[1], $request);
                $controller = $this->findControllerClass($route[1]);

                if (isset($controller["controller"]))
                {
                    $action = $controller["action"];
                    $controller = $this->dependencyInjection($controller["controller"]);

                    return $controller->{$action}($request,...$params);
                }
                else if (isset($controller["invoke"]))
                {
                    $controller = $this->dependencyInjection($controller["invoke"]);

                    return $controller($request,...$params);
                }

                return $route[1]($request, ...$params);
        }

        throw new LogicException("wrong");
    }


    /**
     * @throws ReflectionException
     */
    private function checkRequestInstance($route, $request)
    {
        $validation = $this->getController($route);

        if ($validation)
        {
            $request = new $validation($request);
        }

        return $request;
    }


    private function dependencyInjection($controller)
    {
        global $container;

        if ($container->has($controller)){
            return $container->get($controller);
        }

        return new $controller();
    }

}