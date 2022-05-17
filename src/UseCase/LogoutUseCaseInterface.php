<?php 

namespace App\UseCase;

use Core\Request\Request;

interface LogoutUseCaseInterface 
{
    public function handle(Request $input);
}