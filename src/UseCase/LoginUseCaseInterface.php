<?php 

namespace App\UseCase;

use App\Domain\Inputs\LoginInput;

interface LoginUseCaseInterface 
{
    public function handle(LoginInput $input);
}