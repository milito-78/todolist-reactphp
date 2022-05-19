<?php 
namespace App\Domain\Outputs;

use App\Domain\Entities\Task;

class TaskShowOutput{

    private Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function output():array
    {
        return [
            "data" => [
                "task" => $this->task->toArray()
            ]
        ];
    }


}