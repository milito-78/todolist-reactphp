<?php 
namespace App\UseCase;

interface AuthenticateUseCaseInterface{
    public function authenticate(?string $token);
}