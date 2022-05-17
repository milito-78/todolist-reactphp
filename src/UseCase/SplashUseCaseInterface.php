<?php 

namespace App\UseCase;

use Core\Request\Request;

interface SplashUseCaseInterface 
{
    public function handle(Request $request);
}