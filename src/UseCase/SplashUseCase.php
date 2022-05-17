<?php

namespace App\UseCase;

use App\Core\Repositories\UserRepositoryInterface;
use Core\Request\Request;

class SplashUseCase implements SplashUseCaseInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) 
    {
        $this->userRepository = $userRepository;
    }

    public function handle(Request $request)
    {
        $token = getAuthToken($request);

        $response = [
            "user" => null,
            "timestamp" => time(),
            "version" => "1.0",
            "update_version" => "1.0",
            "api_version" => "1.0",
            "is_essential_update" => false
        ];

        if($token)
        {
            return $this->userRepository
                    ->findByToken($token)
                    ->then(function($user) use ($response){
                        
                        if(!is_null($user)){
                            $response["user"] = $user;
                        }

                        return response($response);
                    });
        }

        return  response($response);
    }
}