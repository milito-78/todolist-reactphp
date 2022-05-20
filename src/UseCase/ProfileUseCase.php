<?php

namespace App\UseCase;

use App\Core\Repositories\UserRepositoryInterface;
use App\Domain\Entities\User;
use App\Domain\Outputs\ProfileOutput;
use Core\Request\Request;


class ProfileUseCase implements ProfileUseCaseInterface
{

    public function handle(Request $input)
    {
        $user = $input->getAuth();

        $output = new ProfileOutput(new User($user));
        return response($output->output());
    }
}