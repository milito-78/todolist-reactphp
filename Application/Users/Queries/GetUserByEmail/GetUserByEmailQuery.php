<?php 
namespace Application\Users\Queries\GetUserByEmail;
use Application\Interfaces\Persistence\UserRepositoryInterface;
use Application\Users\Queries\GetUserByEmail\Exceptions\NotFoundUserException;
use Domain\Users\User;

use function React\Promise\reject;

class GetUserByEmailQuery implements IGetUserByEmailQuery {
    
    
    public function __construct(private UserRepositoryInterface $userRepository) {
    }


	/**
	 * @param string $email
	 * @return \React\Promise\PromiseInterface
	 */
	public function Execute(string $email): \React\Promise\PromiseInterface {
        return $this->userRepository->findByEmail($email)->then(function ($result){
			if(!is_null($result))
				return new User($result);
            return reject(new NotFoundUserException);
        });
	}
}