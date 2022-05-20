<?php 

namespace App\Core\Providers;

use App\Core\Repositories\TaskRepositoryInterface;
use App\Core\Repositories\UserRepositoryInterface;
use App\UseCase\AuthenticateUseCase;
use App\UseCase\AuthenticateUseCaseInterface;
use App\UseCase\LoginUseCase;
use App\UseCase\LoginUseCaseInterface;
use App\UseCase\LogoutUseCase;
use App\UseCase\LogoutUseCaseInterface;
use App\UseCase\ProfileUseCase;
use App\UseCase\ProfileUseCaseInterface;
use App\UseCase\RegisterUseCaseInterface;
use App\UseCase\RegisterUseCase;
use App\UseCase\SplashUseCase;
use App\UseCase\SplashUseCaseInterface;
use App\UseCase\TaskDeleteUseCase;
use App\UseCase\TaskDeleteUseCaseInterface;
use App\UseCase\TaskIndexUseCase;
use App\UseCase\TaskIndexUseCaseInterface;
use App\UseCase\TaskShowUseCase;
use App\UseCase\TaskShowUseCaseInterface;
use App\UseCase\TaskStoreUseCase;
use App\UseCase\TaskStoreUseCaseInterface;
use App\UseCase\TaskUpdateUseCase;
use App\UseCase\TaskUpdateUseCaseInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;

class UseCaseServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [
            AuthenticateUseCaseInterface::class,
            AuthenticateUseCase::class,
            SplashUseCaseInterface::class,
            SplashUseCase::class,
            RegisterUseCaseInterface::class,
            RegisterUseCase::class,
            LoginUseCaseInterface::class,
            LoginUseCase::class,
            LogoutUseCaseInterface::class,
            LogoutUseCase::class,
            ProfileUseCaseInterface::class,
            ProfileUseCase::class,
            TaskIndexUseCaseInterface::class,
            TaskIndexUseCase::class,
            TaskShowUseCaseInterface::class,
            TaskShowUseCase::class,
            TaskDeleteUseCaseInterface::class,
            TaskDeleteUseCase::class,
            TaskStoreUseCaseInterface::class,
            TaskStoreUseCase::class,
            TaskUpdateUseCaseInterface::class,
            TaskUpdateUseCase::class
        ];

        return in_array($id, $services);
    }

    public function register(): void
    {

        $this->getContainer()
            ->add( AuthenticateUseCaseInterface::class, function (){
                return new AuthenticateUseCase($this->getContainer()->get(UserRepositoryInterface::class));
            });

        $this->getContainer()
            ->add(SplashUseCaseInterface::class, function (){
                return new SplashUseCase($this->getContainer()->get(UserRepositoryInterface::class));
            });

        $this->getContainer()
            ->add(RegisterUseCaseInterface::class, function (){
                return new RegisterUseCase($this->getContainer()->get(UserRepositoryInterface::class));
            });

        $this->getContainer()
            ->add(LoginUseCaseInterface::class, function (){
                return new LoginUseCase($this->getContainer()->get(UserRepositoryInterface::class));
            });

        $this->getContainer()
            ->add(LogoutUseCaseInterface::class, function (){
                return new LogoutUseCase();
            });

        $this->getContainer()
            ->add(ProfileUseCaseInterface::class, function (){
                return new ProfileUseCase();
            });

        $this->getContainer()
            ->add(TaskIndexUseCaseInterface::class, function (){
                return new TaskIndexUseCase(
                    $this->getContainer()->get(TaskRepositoryInterface::class)
                );
            });

        $this->getContainer()
            ->add(TaskShowUseCaseInterface::class, function (){
                return new TaskShowUseCase($this->getContainer()->get(TaskRepositoryInterface::class));
            });

        $this->getContainer()
            ->add(TaskDeleteUseCaseInterface::class, function (){
                return new TaskDeleteUseCase($this->getContainer()->get(TaskRepositoryInterface::class));
            });

        $this->getContainer()
            ->add(TaskStoreUseCaseInterface::class, function (){
                return new TaskStoreUseCase($this->getContainer()->get(TaskRepositoryInterface::class));
            });

        $this->getContainer()
            ->add(TaskUpdateUseCaseInterface::class, function (){
                return new TaskUpdateUseCase($this->getContainer()->get(TaskRepositoryInterface::class));
            });
    }
}