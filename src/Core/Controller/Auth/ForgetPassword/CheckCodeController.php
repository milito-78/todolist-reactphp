<?php


namespace App\Core\Controller\Auth\ForgetPassword;


use App\Domain\Inputs\CheckCodeInput;
use App\UseCase\CheckCodeUseCaseInterface;
use Core\Request\Request;

class CheckCodeController
{
    private CheckCodeUseCaseInterface $checkCodeService;

    public function __construct(CheckCodeUseCaseInterface $checkCodeService)
    {
        $this->checkCodeService = $checkCodeService;
    }

    public function __invoke(Request $request)
    {
        $input = new CheckCodeInput($request);
        return $this->checkCodeService->handle($input);
    }
}