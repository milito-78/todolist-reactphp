<?php 

namespace App\UseCase;

use App\Domain\Inputs\ForgetPasswordInput;

interface ForgetPasswordUseCaseInterface
{
    public function handle(ForgetPasswordInput $input);
}