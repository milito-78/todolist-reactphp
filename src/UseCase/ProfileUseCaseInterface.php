<?php

namespace App\UseCase;

use Core\Request\Request;

interface ProfileUseCaseInterface
{
    public function handle(Request $input);
}