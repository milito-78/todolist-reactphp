<?php
namespace Core\DI;

use League\Container\DefinitionContainerInterface;

class DependencyResolver implements DependencyResolverInterface
{

    private DefinitionContainerInterface $container;

    public function __construct()
    {
       global $container;
       $this->container = $container;
    }

    public function make( $class, $params = [])
    {
        
        $reflectionClass    = new \ReflectionClass($class);
        $constructor        = $reflectionClass->getConstructor();
        $tempParams         = [];

        if (!is_null($constructor))
        {
            $constructor_params = $constructor->getParameters();

            foreach ($constructor_params as $param)
            {
                if ($param->hasType())
                {
                    if ($param_class = $param->getClass())
                    {
                        if($this->container->has($param_class->name))
                        {
                            $temp_var = $this->container->get($param_class->name);
                        }
                        elseif (key_exists($param->name,$params))
                        {
                            $temp_var = $params[$param->name];
                        }
                        elseif($param_class->isInterface())
                        {
                            throw new DependencyParamException("Param " .$param->name ." is an interface without value");
                        }
                        elseif ($param->isDefaultValueAvailable())
                        {
                            $temp_var = $param->getDefaultValue();
                        }
                        else
                        {
                            $temp_var =  $this->make($param_class->name);
                        }
                    }
                    elseif($this->container->has($param->name))
                    {
                        $temp_var = $this->container->get($param_class->name);
                    }    
                    elseif (key_exists($param->name,$params))
                    {
                        $temp_var = $params[$param->name];
                    }
                    elseif ($param->isDefaultValueAvailable())
                    {
                        $temp_var = $param->getDefaultValue();
                    }
                    else
                    {
                        throw new DependencyParamException("Class param " .$param->name ." doesn't have default value");
                    }
                
                }
                elseif (key_exists($param->name,$params))
                {
                    $temp_var = $params[$param->name];
                }
                elseif ($param->isDefaultValueAvailable())
                {
                    $temp_var = $param->getDefaultValue();
                }
                else
                {
                    throw new DependencyParamException("Class param " .$param->name ." doesn't have default value");
                }
                $tempParams[$param->getPosition()] = $temp_var;
            }
        }
        return new $class(...$tempParams);
        
    }
}
