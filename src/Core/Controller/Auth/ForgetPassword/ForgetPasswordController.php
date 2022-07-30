<?php

namespace App\Core\Controller\Auth\ForgetPassword;

use App\Domain\Inputs\ForgetPasswordInput;
use App\UseCase\ForgetPasswordUseCaseInterface;
use Core\Request\Controller;
use Core\Request\Request;

class ForgetPasswordController extends Controller
{

    private ForgetPasswordUseCaseInterface $passwordUseCase;

    public function __construct(ForgetPasswordUseCaseInterface $passwordUseCase)
    {
        $this->passwordUseCase = $passwordUseCase;
    }
    
    public function __invoke(Request $request)
    {
        $input = new ForgetPasswordInput($request);
        return $this->passwordUseCase->handle($input);
    }

}