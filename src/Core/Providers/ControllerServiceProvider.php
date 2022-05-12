<?php


namespace App\Core\Providers;

use App\Core\Controller\LoginController;
use App\Core\Controller\ProfileController;
use App\Core\Controller\SplashController;
use App\Core\Controller\RegisterController;
use App\Core\Controller\LogoutController;
use App\Domain\Repositories\UserRepositoryInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ControllerServiceProvider extends AbstractServiceProvider
{

    public function provides(string $id): bool
    {
        $services = [
            RegisterController::class,
            UserRepositoryInterface::class,
            SplashController::class,
            LoginController::class,
            ProfileController::class,
            LogoutController::class,
        ];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $this->getContainer()
            ->add(RegisterController::class)
            ->addArgument(UserRepositoryInterface::class);

        $this->getContainer()
            ->add(SplashController::class)
            ->addArgument(UserRepositoryInterface::class);

        $this->getContainer()
            ->add(LoginController::class)
            ->addArgument(UserRepositoryInterface::class);

        $this->getContainer()
            ->add(ProfileController::class)
            ->addArgument(UserRepositoryInterface::class);

        $this->getContainer()
            ->add(LogoutController::class)
            ->addArgument(UserRepositoryInterface::class);

    }
}