<?php 
namespace App\UseCase;

use App\Domain\Inputs\ChangePasswordInput;

interface ChangePasswordUseCaseInterface
{
    public function handle(ChangePasswordInput $input);
}