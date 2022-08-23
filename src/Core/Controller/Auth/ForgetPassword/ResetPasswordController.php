<?php


namespace App\Core\Controller\Auth\ForgetPassword;


use App\Domain\Inputs\ResetPasswordInput;
use App\UseCase\ResetPasswordUseCaseInterface;
use Core\Request\Request;

class ResetPasswordController
{
    private ResetPasswordUseCaseInterface $resetPasswordService;

    public function __construct(ResetPasswordUseCaseInterface $resetPasswordService)
    {
        $this->resetPasswordService = $resetPasswordService;
    }

    public function __invoke(Request $request)
    {
        $input = new ResetPasswordInput($request);
        return $this->resetPasswordService->handle($input);
    }
}