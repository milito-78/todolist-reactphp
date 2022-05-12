<?php


namespace App\Core\Providers;


use App\Domain\Repositories\UserRepository;
use App\Domain\Repositories\UserRepositoryInterface;
use Core\DataBase\Interfaces\DatabaseInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;

class RepositoryServiceProvider extends AbstractServiceProvider
{

    public function provides(string $id): bool
    {
        $services = [
            UserRepositoryInterface::class,
            UserRepository::class,
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
    }
}