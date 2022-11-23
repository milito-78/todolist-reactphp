<?php
namespace Application\Tasks\Commands\CreateTask;

use Application\Interfaces\Persistence\TaskRepositoryInterface;
use Domain\Tasks\Task;
use React\Promise\PromiseInterface;
use Service\Shared\Helpers\Helpers;

class CreateTaskCommand implements ICreateTaskCommand{
    public function __construct(
        private TaskRepositoryInterface $taskRepository
    )
    {
    }

    public function Execute(CreateTaskModel $model) :PromiseInterface{
        return $this->taskRepository
                    ->create($model->toArray())
                    ->then(function($task){
                        $this->sendImageDeleteSystemEvent($task["image_path"]);
                        return new Task($task);
                    });
    }

    private function sendImageDeleteSystemEvent($image){
        if (!is_null($image) && !empty($image))
            Helpers::emit("server","upload_clean",["image_path"=> $image]);
    }
}