<?php

namespace App\UseCase;

use App\Core\Repositories\UserRepositoryInterface;
use App\Domain\Entities\User;
use App\Domain\Inputs\RegisterInput;
use App\Domain\Outputs\RegisterOutput;
use App\Infrastructure\Exceptions\EmailTakenException;
use Core\Response\JsonResponse;

use function React\Promise\reject;
use function React\Promise\resolve;

class RegisterUseCase implements RegisterUseCaseInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) 
    {
        $this->userRepository = $userRepository;
    }

    public function handle(RegisterInput $input)
    {
        $data = $input->validated();
        $data["api_key"] = $this->generateApiKey();

        return $this->userRepository
                    ->findByEmail($data["email"])
                    ->then(function($result){
                        return is_null($result) ? resolve() : reject(new EmailTakenException("Email is already taken."));
                    })
                    ->then(function() use ($data){
                        return $this->userRepository
                                ->create($data)
                                ->then(function($user){
                                    $output = new RegisterOutput(new User($user));

                                    return response($output->output(),201);
                                });
                    });
                    
    }


    private function generateApiKey()
    {
        return md5(uniqid(rand(), true));
    }
}