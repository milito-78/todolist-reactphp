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
        var_dump(password_hash("12345678", PASSWORD_BCRYPT));
        $input = new LoginInput($request);
        return $this->loginService->handle($input);
    }

}