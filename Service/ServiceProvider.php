<?php 

namespace Service;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

class ServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    
    public function provides(string $id): bool
    {
        $services = [
        ];

        return in_array($id, $services);
    }

    public function register(): void
    {
        
    }

    public function boot(): void
    {
        
    }

}