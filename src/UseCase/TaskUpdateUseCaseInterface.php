<?php 

namespace App\UseCase;

use App\Domain\Inputs\TaskUpdateInput;

interface TaskUpdateUseCaseInterface 
{
    public function handle(TaskUpdateInput $input,$task);
}