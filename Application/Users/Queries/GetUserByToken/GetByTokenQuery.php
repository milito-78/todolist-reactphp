<?php


namespace Application\Users\Queries\GetUserByToken;


use Application\Interfaces\Persistence\UserRepositoryInterface;
use Application\Users\Queries\GetUserByEmail\Exceptions\NotFoundUserException;
use Domain\Users\User;

use function React\Promise\reject;
use function React\Promise\resolve;

class GetByTokenQuery implements GetByTokenQueryInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function Execute(?string $token)
    {
        if(is_null($token))
        {
            return reject();
        }

        return $this->userRepository->findByToken($token)->then(function ($result){
			if(!is_null($result))
				return new User($result);
            return reject();
        });
    }
}