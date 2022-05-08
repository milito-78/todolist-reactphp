<?php

namespace App\Core\Controller;

use App\Domain\Repositories\UserRepositoryInterface;
use Core\Request\Controller;
use Core\Request\Request;

class SplashController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository   = $userRepository;
    }

    public function __invoke(Request $request)
    {
        $token = $request->getHeader("Authorization");

        $response = [
            "user" => null,
            "timestamp" => time(),
            "version" => "1.0",
            "update_version" => "1.0",
            "api_version" => "1.0",
            "is_essential_update" => false
        ];

        if(count($token) && $token = $token[0])
        {
            return $this->userRepository
                        ->findByToken($token)
                        ->then(function($data) use ($response){
                            echo get_class($data);
                            
                            if(!is_null($data)){
                                $response["user"] = $data;
                            }

                            return response($response);
                        });
        }

        return  response($response);
    }
}