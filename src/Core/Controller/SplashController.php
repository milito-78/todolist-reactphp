<?php

namespace App\Core\Controller;

use App\UseCase\SplashUseCaseInterface;
use Core\Request\Controller;
use Core\Request\Request;

class SplashController extends Controller
{
    private SplashUseCaseInterface $splashService;

    public function __construct(SplashUseCaseInterface $splashService)
    {
        $this->splashService   = $splashService;
    }

    public function __invoke(Request $request)
    {
        return $this->splashService->handle($request);
    }
}