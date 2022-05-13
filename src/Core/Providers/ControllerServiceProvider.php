<?php


namespace App\Core\Providers;

use App\Core\Controller\LoginController;
use App\Core\Controller\ProfileController;
use App\Core\Controller\SplashController;
use App\Core\Controller\RegisterController;
use App\Core\Controller\LogoutController;
use App\Core\Controller\Task\TaskDeleteController;
use App\Core\Controller\Task\TaskIndexController;
use App\Core\Controller\Task\TaskShowController;
use App\Core\Controller\Task\TaskStoreController;
use App\Core\Controller\Task\TaskUpdateController;
use App\Domain\Repositories\TaskRepositoryInterface;
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
            TaskIndexController::class,
            TaskRepositoryInterface::class,
            TaskShowController::class,
            TaskDeleteController::class,
            TaskStoreController::class,
            TaskUpdateController::class
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

        $this->getContainer()
            ->add(TaskIndexController::class)
            ->addArgument(TaskRepositoryInterface::class)
            ->addArgument(UserRepositoryInterface::class);

        $this->getContainer()
            ->add(TaskShowController::class)
            ->addArgument(TaskRepositoryInterface::class)
            ->addArgument(UserRepositoryInterface::class);

        $this->getContainer()
            ->add(TaskDeleteController::class)
            ->addArgument(TaskRepositoryInterface::class)
            ->addArgument(UserRepositoryInterface::class);

        $this->getContainer()
            ->add(TaskStoreController::class)
            ->addArgument(TaskRepositoryInterface::class)
            ->addArgument(UserRepositoryInterface::class);
        $this->getContainer()
            ->add(TaskUpdateController::class)
            ->addArgument(TaskRepositoryInterface::class)
            ->addArgument(UserRepositoryInterface::class);

    }
}