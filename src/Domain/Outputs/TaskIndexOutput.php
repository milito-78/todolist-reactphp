<?php 
namespace App\Domain\Outputs;

use App\Domain\Entities\Task;

class TaskIndexOutput{

    private array $tasks;

    public function __construct(array $tasks)
    {
        $this->tasks = $tasks;
    }

    public function output():array
    {
        $tasks = $this->getTasks();

        return [
            "data" => [
                "items" => $tasks
            ]
        ];
    }

    private function getTasks(){
        return array_map(function (Task $task){
            return $task->toArray();
        },$this->tasks);
    }
}