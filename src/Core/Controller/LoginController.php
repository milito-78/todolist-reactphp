<?php

namespace App\Core\Controller;

use App\Domain\Inputs\LoginInput;
use App\UseCase\LoginUseCaseInterface;
use Core\Request\Controller;
use Core\Request\Request;

class LoginController extends Controller
{
    private LoginUseCaseInterface $loginService;

    public function __construct(LoginUseCaseInterface $loginService)
    {
        $this->loginService   = $loginService;
    }
    
    public function __invoke(Request $request)
    {
        $input = new LoginInput($request);
        $input->validate();

        return $this->loginService->handle($input);
    }

}