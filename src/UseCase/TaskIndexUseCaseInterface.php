<?php

namespace App\UseCase;

use Core\Request\Request;

interface TaskIndexUseCaseInterface
{
    public function handle(Request $request);
}