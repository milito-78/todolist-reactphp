<?php 

namespace Application;

use Application\Codes\Commands\CreateCode\CreateCodeCommand;
use Application\Codes\Commands\CreateCode\ICreateCodeCommand;
use Application\Codes\Commands\SaveCode\ISaveCodeCommand;
use Application\Codes\Commands\SaveCode\SaveCodeCommand;
use Application\Codes\Queries\GetCodeByToken\GetCodeByTokenQuery;
use Application\Codes\Queries\GetCodeByToken\IGetCodeByTokenQuery;
use Application\Interfaces\Persistence\ICodeRepository;
use Application\Interfaces\Persistence\TaskRepositoryInterface;
use Application\Interfaces\Persistence\UserRepositoryInterface;
use Application\Tasks\Commands\CreateTask\CreateTaskCommand;
use Application\Tasks\Commands\CreateTask\ICreateTaskCommand;
use Application\Tasks\Commands\CreateTaskForUser\CreateTaskForUserCommand;
use Application\Tasks\Commands\CreateTaskForUser\ICreateTaskForUserCommand;
use Application\Tasks\Queries\GetTaskById\GetTaskByIdQuery;
use Application\Tasks\Queries\GetTaskById\IGetTaskByIdQuery;
use Application\Tasks\Queries\GetTasksWithPaginate\GetByPaginateQuery;
use Application\Tasks\Queries\GetTasksWithPaginate\IGetByPaginateQuery;
use Application\Users\Commands\ChangePassword\ChangePasswordCommand;
use Application\Users\Commands\ChangePassword\IChangePasswordCommand;
use Application\Users\Commands\CreateUser\CreateUserCommand;
use Application\Users\Commands\CreateUser\ICreateUserCommand;
use Application\Users\Commands\ForgetPassword\ForgetPasswordUserCommand;
use Application\Users\Commands\ForgetPassword\IForgetPasswordUserCommand;
use Application\Users\Commands\RegisterUser\IRegisterUserCommand;
use Application\Users\Commands\RegisterUser\RegisterUserCommand;
use Application\Users\Commands\ResetPassword\IResetPasswordCommand;
use Application\Users\Commands\ResetPassword\ResetPasswordCommand;
use Application\Users\Queries\CheckForgetPasswordCode\CheckForgetPasswordCodeQuery;
use Application\Users\Queries\CheckForgetPasswordCode\ICheckForgetPasswordCodeQuery;
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
        $services = array_merge(
            $this->usersProvides(),
            $this->codesProvides(),
            $this->tasksProvides()
        );

        return in_array($id, $services);
    }

    public function register(): void
    {
        $this->codes();
        $this->users();
        $this->tasks();
    }

    public function boot(): void
    {
        
    }

    private function users(){
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
            IForgetPasswordUserCommand::class,new ForgetPasswordUserCommand($this->getContainer()->get(IGetUserByEmailQuery::class),$this->getContainer()->get(ICreateCodeCommand::class))
        );
        $this->getContainer()
        ->add(
            ICheckForgetPasswordCodeQuery::class,new CheckForgetPasswordCodeQuery($this->getContainer()->get(IGetCodeByTokenQuery::class),$this->getContainer()->get(IGetUserByEmailQuery::class))
        );
        $this->getContainer()
        ->add(
            IResetPasswordCommand::class,new ResetPasswordCommand($this->getContainer()->get(ICheckForgetPasswordCodeQuery::class),$this->getContainer()->get(UserRepositoryInterface::class))
        );
        $this->getContainer()
        ->add(
            IChangePasswordCommand::class,new ChangePasswordCommand($this->getContainer()->get(UserRepositoryInterface::class))
        );
    }
    private function usersProvides():array{
        return [
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
            IForgetPasswordUserCommand::class,
            ForgetPasswordUserCommand::class,
            ICheckForgetPasswordCodeQuery::class,
            CheckForgetPasswordCodeQuery::class,
            IResetPasswordCommand::class,
            ResetPasswordCommand::class,
            IChangePasswordCommand::class,
            ChangePasswordCommand::class
        ];
    }
    
    private function tasks(){
        $this->getContainer()
        ->add(
            IGetByPaginateQuery::class,new GetByPaginateQuery($this->getContainer()->get(TaskRepositoryInterface::class))
        );
        $this->getContainer()
        ->add(
            IGetTaskByIdQuery::class,new GetTaskByIdQuery($this->getContainer()->get(TaskRepositoryInterface::class))
        );
        $this->getContainer()
        ->add(
            ICreateTaskCommand::class,new CreateTaskCommand($this->getContainer()->get(TaskRepositoryInterface::class))
        );
        $this->getContainer()
        ->add(
            ICreateTaskForUserCommand::class,new CreateTaskForUserCommand($this->getContainer()->get(ICreateTaskCommand::class),$this->getContainer()->get(IGetTaskByIdQuery::class))
        );
    }

    private function tasksProvides():array{
        return [
            IGetByPaginateQuery::class,
            GetByPaginateQuery::class,
            IGetTaskByIdQuery::class,
            GetTaskByIdQuery::class,
            ICreateTaskCommand::class,
            CreateTaskCommand::class,
            ICreateTaskForUserCommand::class,
            CreateTaskForUserCommand::class,
        ];
    }
    
    private function codes(){
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
    }

    private function codesProvides():array{
        return [
            IGetCodeByTokenQuery::class,
            GetCodeByTokenQuery::class,
            ISaveCodeCommand::class,
            SaveCodeCommand::class,
            ICreateCodeCommand::class,
            CreateCodeCommand::class,
        ];
    }

}