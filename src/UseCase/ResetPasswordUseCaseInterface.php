<?php 

namespace App\UseCase;

use App\Domain\Inputs\ResetPasswordInput;

interface ResetPasswordUseCaseInterface
{
    public function handle(ResetPasswordInput $input);
}