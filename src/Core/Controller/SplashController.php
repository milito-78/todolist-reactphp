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

    public function index(Request $request)
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

        // $token = ["wsdhjfgtygefvdgvfsdgbegvcgvtdyec"];

        if(count($token) && $token = $token[0])
        {
            return $this->userRepository
                        ->findByToken($token)
                        ->then(function($user) use ($response){
                            
                            if(!is_null($user)){
                                $response["user"] = $user;
                            }

                            return response($response);
                        },
                        function($exception)
                        {
                            return response("sss");
                        });
        }

        return  response($response);
    }
}