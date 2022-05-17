<?php

namespace App\Core\Controller;

use App\UseCase\AuthenticateUseCaseInterface;
use Core\Request\Controller;
use Core\Request\Request;

class SplashController extends Controller
{
    private AuthenticateUseCaseInterface $authService;

    public function __construct(AuthenticateUseCaseInterface $authService)
    {
        $this->authService   = $authService;
    }

    public function __invoke(Request $request)
    {
        $auth = $request->getAuth();

        $response = [
            "user" => $auth,
            "timestamp" => time(),
            "version" => "1.0",
            "update_version" => "1.0",
            "api_version" => "1.0",
            "is_essential_update" => false
        ];

        
        return  response($response);
    }
}