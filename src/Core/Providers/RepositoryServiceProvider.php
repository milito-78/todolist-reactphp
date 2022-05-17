<?php


namespace App\Core\Providers;

use App\Core\Repositories\TaskRepository;
use App\Core\Repositories\TaskRepositoryInterface;
use App\Core\Repositories\UserRepository;
use App\Core\Repositories\UserRepositoryInterface;
use Core\DataBase\Interfaces\DatabaseInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;

class RepositoryServiceProvider extends AbstractServiceProvider
{

    public function provides(string $id): bool
    {
        $services = [
            UserRepositoryInterface::class,
            UserRepository::class,
            TaskRepositoryInterface::class,
            TaskRepository::class,
            DatabaseInterface::class,
        ];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $this->getContainer()
            ->add(UserRepositoryInterface::class,function (){
                return new UserRepository($this->getContainer()->get(DatabaseInterface::class));
            });
    
        $this->getContainer()
            ->add(TaskRepositoryInterface::class,function (){
                return new TaskRepository($this->getContainer()->get(DatabaseInterface::class));
            });

        
    }
}