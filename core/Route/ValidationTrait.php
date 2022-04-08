<?php


namespace Core\Route;

use Core\Request\Request;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use Core\Request\ValidationRequest;

trait ValidationTrait
{

    /**
     * @throws ReflectionException
     */
    private function findController($middleware): ReflectionMethod
    {
        if (is_array($middleware)){
            return new ReflectionMethod($middleware[0], $middleware[1]);
        }
        return $this->findController($middleware->middleware);
    }

    /**
     * @throws ReflectionException
     */
    public function getController($middleware): ?string
    {
        $controller = $this->findController($middleware);

        $params = $controller->getParameters();
        $validation = null;
        foreach ($params as $f){
            $z = new ReflectionClass(@$f->getClass()->name);

            if(in_array(ValidationRequest::class,$z->getInterfaceNames()) || @$f->getClass()->name == Request::class){
                $validation = $f->getClass()->name;
                break;
            }
        }

        return $validation;
    }

}