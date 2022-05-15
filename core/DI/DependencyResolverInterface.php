<?php 
namespace Core\DI;

interface DependencyResolverInterface
{
    public function make( $class, $params = []);
}