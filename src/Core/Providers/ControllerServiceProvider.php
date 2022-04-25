<?php


namespace App\Core\Providers;


use App\Core\Controller\UserController;
use App\Domain\Repositories\UserRepositoryInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ControllerServiceProvider extends AbstractServiceProvider
{

    public function provides(string $id): bool
    {
        $services = [
            UserController::class,
            UserRepositoryInterface::class,
        ];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $this->getContainer()
            ->add(UserController::class)
            ->addArgument(UserRepositoryInterface::class);

    }
}