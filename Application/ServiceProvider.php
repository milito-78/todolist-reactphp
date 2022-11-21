<?php 

namespace Application;

use Application\Codes\Commands\CreateCode\CreateCodeCommand;
use Application\Codes\Commands\CreateCode\ICreateCodeCommand;
use Application\Codes\Commands\SaveCode\ISaveCodeCommand;
use Application\Codes\Commands\SaveCode\SaveCodeCommand;
use Application\Codes\Queries\GetCodeByToken\GetCodeByTokenQuery;
use Application\Codes\Queries\GetCodeByToken\IGetCodeByTokenQuery;
use Application\Interfaces\Persistence\ICodeRepository;
use Application\Interfaces\Persistence\UserRepositoryInterface;
use Application\Users\Commands\CreateUser\CreateUserCommand;
use Application\Users\Commands\CreateUser\ICreateUserCommand;
use Application\Users\Commands\RegisterUser\IRegisterUserCommand;
use Application\Users\Commands\RegisterUser\RegisterUserCommand;
use Application\Users\Queries\ForgetPassword\ForgetPasswordUserQuery;
use Application\Users\Queries\ForgetPassword\IForgetPasswordUserQuery;
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
            IGetCodeByTokenQuery::class,
            GetCodeByTokenQuery::class,
            ISaveCodeCommand::class,
            SaveCodeCommand::class,
            ICreateCodeCommand::class,
            CreateCodeCommand::class,
            IForgetPasswordUserQuery::class,
            ForgetPasswordUserQuery::class,
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
        $this->getContainer()
        ->add(
            ISaveCodeCommand::class,new SaveCodeCommand($this->getContainer()->get(ICodeRepository::class))
        );
        $this->getContainer()
        ->add(
            IGetCodeByTokenQuery::class,new GetCodeByTokenQuery($this->getContainer()->get(ICodeRepository::class))
        );
        $this->getContainer()
        ->add(
            ICreateCodeCommand::class,new CreateCodeCommand($this->getContainer()->get(IGetCodeByTokenQuery::class),$this->getContainer()->get(ISaveCodeCommand::class))
        );
        $this->getContainer()
        ->add(
            IForgetPasswordUserQuery::class,new ForgetPasswordUserQuery($this->getContainer()->get(IGetUserByEmailQuery::class),$this->getContainer()->get(ICreateCodeCommand::class))
        );
    }

    public function boot(): void
    {
        
    }

}