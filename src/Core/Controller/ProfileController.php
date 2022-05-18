<?php

namespace App\Core\Controller;

use App\UseCase\ProfileUseCaseInterface;
use Core\Request\Controller;
use Core\Request\Request;

class ProfileController extends Controller
{
    private ProfileUseCaseInterface $profileService;

    public function __construct(ProfileUseCaseInterface $profileService)
    {
        $this->profileService   = $profileService;
    }
    
    public function show(Request $request)
    {
       return $this->profileService->handle($request);
    }

}