<?php 

namespace App\UseCase;

use App\Domain\Inputs\RegisterInput;

interface RegisterUseCaseInterface 
{
    public function handle(RegisterInput $input);
}