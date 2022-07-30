<?php 

namespace App\UseCase;

use App\Domain\Inputs\CheckCodeInput;

interface CheckCodeUseCaseInterface
{
    public function handle(CheckCodeInput $input);
}