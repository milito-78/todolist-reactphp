<?php
namespace Application\Users\Commands\RegisterUser;

use Application\Users\Commands\CreateUser\CreateUserModel;
use Application\Users\Commands\CreateUser\ICreateUserCommand;
use Application\Users\Commands\RegisterUser\Exceptions\UserExistsException;
use Application\Users\Queries\GetUserByEmail\Exceptions\NotFoundUserException;
use Application\Users\Queries\GetUserByEmail\IGetUserByEmailQuery;
use Domain\Users\User;
use React\Promise\PromiseInterface;

use function React\Promise\reject;

class RegisterUserCommand implements IRegisterUserCommand{
    
    public function __construct(
        private ICreateUserCommand $command,
        private IGetUserByEmailQuery $query,
    ) {
    }

	/**
	 * @return PromiseInterface
	 */

	public function Execute(RegisterUserModel $model): PromiseInterface {
        return $this->query->Execute($model->email)
                ->then(function(User $user){
                    return reject(new UserExistsException());
                },function(NotFoundUserException $exception) use ($model){
                    return $this->command->Execute(
                        $this->generateData($model)
                    )->then(function(User $user){
                        return $this->query->Execute($user->email);
                    });
                });

	}

    private function generateData(RegisterUserModel $model) : CreateUserModel{
        return new CreateUserModel(
            $model->email,
            $model->password,
            $model->full_name
        );
    }
}