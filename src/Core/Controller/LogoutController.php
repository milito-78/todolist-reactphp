<?php

namespace App\Core\Controller;

use App\UseCase\LogoutUseCaseInterface;
use Core\Request\Controller;
use Core\Request\Request;

class LogoutController extends Controller
{
    private LogoutUseCaseInterface $logoutService;

    public function __construct(LogoutUseCaseInterface $logoutService)
    {
        $this->logoutService   = $logoutService;
    }
    
    public function __invoke(Request $request)
    {
        return $this->logoutService->handle($request);
    }

}