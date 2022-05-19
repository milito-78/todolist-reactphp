<?php

namespace App\UseCase;

use Core\Request\Request;

interface TaskDeleteUseCaseInterface
{
    public function handle(Request $request,$task);
}