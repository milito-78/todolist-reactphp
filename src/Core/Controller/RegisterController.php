<?php

namespace App\Core\Controller;

use App\Domain\Repositories\UserRepositoryInterface;
use Core\Request\Controller;
use Core\Request\Request;

class RegisterController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository   = $userRepository;
    }
    
    public function store(Request $request)
    {
        $data = [
            "email"     => $request->email,
            "password"  => password_hash($request->password, PASSWORD_BCRYPT),
            "full_name" => $request->full_name,
            "api_key"   => $this->generateApiKey()
        ];
        
        return $this->userRepository->create($data)
                    ->then(function($result){
                    
                        return response($result);
                    },function($ex){
                        return response($ex->getMessage());
                    });
    }

    public function generateApiKey()
    {
        return md5(uniqid(rand(), true));
    }
}