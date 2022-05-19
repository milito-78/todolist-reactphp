<?php 

namespace App\UseCase;

use App\Domain\Inputs\TaskStoreInput;

interface TaskStoreUseCaseInterface 
{
    public function handle(TaskStoreInput $input);
}