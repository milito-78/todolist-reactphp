<?php

namespace App\Core\Controller\Profile;

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
    
    public function __invoke(Request $request)
    {
       return $this->profileService->handle($request);
    }

}