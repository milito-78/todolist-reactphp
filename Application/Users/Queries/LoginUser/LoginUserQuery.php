<?php
namespace Application\Users\Queries\LoginUser;

use Application\Users\Queries\GetUserByEmail\Exceptions\NotFoundUserException;
use Application\Users\Queries\GetUserByEmail\IGetUserByEmailQuery;
use Application\Users\Queries\LoginUser\Exceptions\CredentialException;
use Domain\Users\User;
use React\Promise\PromiseInterface;

use function React\Promise\reject;

class LoginUserQuery implements ILoginUserQuery{
     /**
     */
    public function __construct(private IGetUserByEmailQuery $query) {
    }

    public function Execute(string $email, string $password) :PromiseInterface{
        return $this->query->Execute($email)
                    ->then(function(User $user) use ($password){
                        if(!$user->isPasswordCorrect($password))
                            return reject(new CredentialException("User or Password is incorrect"));
                        
                        return $user;
                    },function(NotFoundUserException $exception){
                        return reject(new CredentialException("User or Password is incorrect"));
                    });
    }
}