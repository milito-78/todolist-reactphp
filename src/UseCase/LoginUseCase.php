<?php

namespace App\UseCase;

use App\Core\Repositories\UserRepositoryInterface;
use App\Domain\Entities\User;
use App\Domain\Inputs\LoginInput;
use App\Domain\Outputs\LoginOutput;
use App\Infrastructure\Exceptions\CredentialException;

use function React\Promise\reject;

class LoginUseCase implements LoginUseCaseInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) 
    {
        $this->userRepository = $userRepository;
    }

    public function handle(LoginInput $input)
    {

        return $this->userRepository
                    ->findByEmail($input->email())
                    ->then(function($user) use ($input){
                        if(is_null($user) || !password_verify($input->password(), $user["password"]))
                        {
                            return reject(new CredentialException("Email or password is incorrect"));
                        }
                        $output = new LoginOutput(new User($user));

                        return response($output->output());
                    });                  
    }


}