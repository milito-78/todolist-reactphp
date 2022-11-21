<?php
namespace Application\Users\Commands\CreateUser;

use Application\Interfaces\Persistence\UserRepositoryInterface;
use Domain\Users\User;
use React\Promise\PromiseInterface;

class CreateUserCommand implements ICreateUserCommand{
    
    public function __construct(private UserRepositoryInterface $userRepository) {
    }

	/**
	 * @return PromiseInterface
	 */

	public function Execute(CreateUserModel $model): PromiseInterface {

        return $this->userRepository
                    ->create(
                        $this->generateData(
                            $model->toArray(),
                        )
                    )
                    ->then(function($user){
                        return new User($user);
                    });
	}

    private function generateData(array $data){
        return array_merge($data,[
            "password"  => User::hashedPassword($data["password"]),
            "api_key"   => $this->generateApiKey()
        ]);
    }

    private function generateApiKey(): string
    {
        return md5(uniqid(time(), true));
    }
}