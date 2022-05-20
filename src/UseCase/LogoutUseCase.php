<?php

namespace App\UseCase;

use App\Core\Repositories\UserRepositoryInterface;
use Core\Request\Request;


class LogoutUseCase implements LogoutUseCaseInterface
{
 
    public function handle(Request $input)
    {
        return response(["message" => "Logout completed successfully"]);
    }


}