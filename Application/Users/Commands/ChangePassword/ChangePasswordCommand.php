<?php
namespace Application\Users\Commands\ChangePassword;

use Application\Interfaces\Persistence\UserRepositoryInterface;
use Application\Users\Queries\LoginUser\Exceptions\CredentialException;
use Domain\Users\User;
use React\Promise\PromiseInterface;
use Service\Shared\Exceptions\NotFoundException;

use function React\Promise\reject;

class ChangePasswordCommand implements IChangePasswordCommand{
    
    /**
     * constructor function
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        private UserRepositoryInterface $userRepository
    )
    {
    }

	/**
	 * Execute function
	 *
	 * @param int $user_id
	 * @param string $current_password
	 * @param string $new_password
	 * @return PromiseInterface
	 */
	public function Execute(int $user_id, string $current_password, string $new_password): PromiseInterface {
        return $this->userRepository
                    ->find($user_id)
                    ->then(function($value) use ($current_password,$new_password){
                        if(is_null($value))
                            return reject(new NotFoundException());
                        
                        $user = new User($value);
                        if(!$user->isPasswordCorrect($current_password))
                            return reject(new CredentialException("Current password is incorrect"));
                        return $this->userRepository
                                    ->update($user->id,[
                                        "password" => User::hashedPassword($new_password)
                                    ])->then(function ($res) {
                                        return true;
                                    });
                    });
	}
}