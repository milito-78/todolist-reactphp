<?php


namespace App\Core\Providers;

use App\Core\Repositories\TaskRepository;
use App\Core\Repositories\TaskRepositoryInterface;
use App\Core\Repositories\UploadRepository;
use App\Core\Repositories\UploadRepositoryInterface;
use App\Core\Repositories\UserRepository;
use App\Core\Repositories\UserRepositoryInterface;
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
            UploadRepositoryInterface::class,
            UploadRepository::class
        ];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $this->getContainer()
            ->add(UserRepositoryInterface::class,UserRepository::class);
    
        $this->getContainer()
            ->add(TaskRepositoryInterface::class,TaskRepository::class);
    
        $this->getContainer()
            ->add(UploadRepositoryInterface::class,UploadRepository::class);
    }
}