<?php

namespace App\UseCase;

use Core\Request\Request;

interface TaskShowUseCaseInterface
{
    public function handle(Request $request,$task);
}