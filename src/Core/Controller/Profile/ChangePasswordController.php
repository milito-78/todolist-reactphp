<?php

namespace App\Core\Controller\Profile;

use App\Domain\Inputs\ChangePasswordInput;
use App\UseCase\ChangePasswordUseCaseInterface;
use Core\Request\Controller;
use Core\Request\Request;

class ChangePasswordController extends Controller
{
    private ChangePasswordUseCaseInterface $changePasswordService;

    public function __construct(ChangePasswordUseCaseInterface $passwordUseCase)
    {
        $this->changePasswordService   = $passwordUseCase;
    }
    
    public function __invoke(Request $request)
    {
        $input = new ChangePasswordInput($request);
        return $this->changePasswordService->handle($input);
    }

}