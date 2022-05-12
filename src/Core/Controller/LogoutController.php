<?php

namespace App\Core\Controller;

use App\Domain\Repositories\UserRepositoryInterface;
use Core\Request\Controller;
use Core\Request\Request;

class LogoutController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository   = $userRepository;
    }
    
    public function patch(Request $request)
    {
        $token = $request->getHeader("Authorization");

        if(count($token) && $token = $token[0])
        {
            return $this->userRepository
                        ->findByToken($token)
                        ->then(function($user)
                        {   
                            if(is_null($user)){
                                return  response("Un authenticated" , 401);
                            }

                            return response("Logout successfully");
                        },
                        function($exception)
                        {
                            return response($exception->getMessage());
                        });
        }

        return  response("Un authenticated" , 401);
    }

}