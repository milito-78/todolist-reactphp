<?php 

namespace Infrastructure;

use Application\Interfaces\Infrastructure\DI\DependencyResolverInterface;
use Infrastructure\DI\DependencyResolver;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

class ServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    
    public function provides(string $id): bool
    {
        $services = [
            DependencyResolverInterface::class,
            DependencyResolver::class
        ];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $this->getContainer()->add(DependencyResolverInterface::class,new DependencyResolver($this->getContainer()));
    }

    public function boot(): void
    {
        
    }

}