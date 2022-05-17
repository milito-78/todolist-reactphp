<?php 

namespace App\Core\Providers;

use App\Domain\Repositories\UserRepositoryInterface;
use App\UseCase\AuthenticateUseCase;
use App\UseCase\AuthenticateUseCaseInterface;
use App\UseCase\SplashUseCase;
use App\UseCase\SplashUseCaseInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;

class UseCaseServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [
            AuthenticateUseCaseInterface::class,
            AuthenticateUseCase::class,
            SplashUseCaseInterface::class,
            SplashUseCase::class
    
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
    }
}