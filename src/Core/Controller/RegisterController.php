<?php

namespace App\Core\Controller;

use App\Domain\Inputs\RegisterInput;
use App\UseCase\RegisterUseCaseInterface;
use Core\Request\Controller;
use Core\Request\Request;

class RegisterController extends Controller
{
    private RegisterUseCaseInterface $registerService;
    public function __construct(RegisterUseCaseInterface $registerService)
    {
        $this->registerService   = $registerService;
    }
    
    public function __invoke(Request $request)
    {
        $input = new RegisterInput($request);
        $input->validate();

        return $this->registerService->handle($input);
    }

}