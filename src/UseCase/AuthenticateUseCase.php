<?php 

namespace App\UseCase;

use App\Core\Repositories\UserRepositoryInterface;
use Core\Exceptions\AuthorizationException;

class AuthenticateUseCase implements AuthenticateUseCaseInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository   = $userRepository;
    }

    public function authenticate(?string $token)
    {
        if(is_null($token))
        {
            throw new AuthorizationException("Token is invalid",401);
        }

        return $this->userRepository->findByToken($token)
                ->then(function($user)
                {
                    if(is_null($user))
                    {
                        throw new AuthorizationException("Token is invalid",401);
                    }

                    return $user;
                });
    }
}