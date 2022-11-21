<?php 

namespace Application;

use Application\Interfaces\Persistence\UserRepositoryInterface;
use Application\Users\Commands\CreateUser\CreateUserCommand;
use Application\Users\Commands\CreateUser\ICreateUserCommand;
use Application\Users\Commands\RegisterUser\IRegisterUserCommand;
use Application\Users\Commands\RegisterUser\RegisterUserCommand;
use Application\Users\Queries\GetUserByEmail\GetUserByEmailQuery;
use Application\Users\Queries\GetUserByEmail\IGetUserByEmailQuery;
use Application\Users\Queries\GetUserByToken\GetByTokenQuery;
use Application\Users\Queries\GetUserByToken\GetByTokenQueryInterface;
use Application\Users\Queries\LoginUser\ILoginUserQuery;
use Application\Users\Queries\LoginUser\LoginUserQuery;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

class ServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    
    public function provides(string $id): bool
    {
        $services = [
            GetByTokenQueryInterface::class,
            GetByTokenQuery::class,
            IGetUserByEmailQuery::class,
            GetUserByEmailQuery::class,
            ICreateUserCommand::class,
            CreateUserCommand::class,
            IRegisterUserCommand::class,
            RegisterUserCommand::class,
            ILoginUserQuery::class,
            LoginUserQuery::class,
        ];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $this->getContainer()
        ->add(
            GetByTokenQueryInterface::class,new GetByTokenQuery($this->getContainer()->get(UserRepositoryInterface::class))
        );
        $this->getContainer()
        ->add(
            IGetUserByEmailQuery::class,new GetUserByEmailQuery($this->getContainer()->get(UserRepositoryInterface::class))
        );
        $this->getContainer()
        ->add(
            ICreateUserCommand::class,new CreateUserCommand($this->getContainer()->get(UserRepositoryInterface::class))
        );
        $this->getContainer()
        ->add(
            IRegisterUserCommand::class,new RegisterUserCommand($this->getContainer()->get(ICreateUserCommand::class),$this->getContainer()->get(IGetUserByEmailQuery::class))
        );
        $this->getContainer()
        ->add(
            ILoginUserQuery::class,new LoginUserQuery($this->getContainer()->get(IGetUserByEmailQuery::class))
        );
    }

    public function boot(): void
    {
        
    }

}