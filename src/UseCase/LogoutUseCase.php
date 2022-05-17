<?php

namespace App\UseCase;

use App\Core\Repositories\UserRepositoryInterface;
use Core\Request\Request;

use function React\Promise\reject;

class LogoutUseCase implements LogoutUseCaseInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) 
    {
        $this->userRepository = $userRepository;
    }

    public function handle(Request $input)
    {
        return response(["message" => "Logout completed successfully"]);
    }


}