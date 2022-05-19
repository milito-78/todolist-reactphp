<?php 
namespace App\Domain\Outputs;

use App\Domain\Entities\Task;

class TaskStoreOutput{

    private Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function output():array
    {
        return [
            "message" => "Task created successfully",
            "data" => [
                "task" => [
                    "id"            => $this->task->id,
                    "title"         => $this->task->title,
                    "description"   => $this->task->description,
                    "deadline"      => $this->task->getDeadlineDateTimeString(),
                    "image"         => $this->task->image_path,
                ]
            ]
        ];
    }


}