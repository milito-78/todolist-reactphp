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
            "data" => $tasks
        ];
    }

    private function getTasks(){
        $this->tasks["data"] = array_map(function (Task $task){
            return $task->toArray();
        },$this->tasks["data"]);

        return $this->tasks;
    }
}