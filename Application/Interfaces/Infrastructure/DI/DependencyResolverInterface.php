<?php 
namespace Application\Interfaces\Infrastructure\DI;

interface DependencyResolverInterface
{
    public function make( $class, $params = []);
}