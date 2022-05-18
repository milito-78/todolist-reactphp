<?php

namespace App\UseCase;

use App\Core\Repositories\UserRepositoryInterface;
use App\Domain\Entities\User;
use App\Domain\Outputs\SplashOutput;
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

        $option = [
            "user"                  => null,
            "timestamp"             => time(),
            "version"               => "1.0",
            "update_version"        => "1.0",
            "api_version"           => "1.0",
            "is_essential_update"   => false
        ];

        if($token)
        {
            return $this->userRepository
                    ->findByToken($token)
                    ->then(function($user) use ($option){
                        
                        if(!is_null($user)){
                            $user = new User($user);
                        }
                        $output = new SplashOutput($option,$user);
                        return response($output->output());
                    });
        }
        $output = new SplashOutput($option,null);

        return response($output->output());
    }
}