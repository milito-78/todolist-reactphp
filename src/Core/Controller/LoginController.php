<?php

namespace App\Core\Controller;

use App\Domain\Repositories\UserRepositoryInterface;
use Core\Request\Controller;
use Core\Request\Request;

class LoginController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository   = $userRepository;
    }
    
    public function store(Request $request)
    {
       
        
        return $this->userRepository->findByEmail($request->email)
                    ->then(function($result) use ($request){
                        if(is_null($result))
                        {
                            return response("failed to login" , 401);
                        }
                        
                        if(!password_verify($request->password, $result["password"]))
                        {
                            return response("password is incorrect" , 401);
                        }

                        return response($result);
                    },function($ex){
                        return response($ex->getMessage());
                    });
    }

}