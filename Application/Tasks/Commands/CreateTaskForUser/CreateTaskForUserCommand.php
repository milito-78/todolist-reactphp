<?php
namespace Application\Tasks\Commands\CreateTaskForUser;


use Application\Tasks\Commands\CreateTask\CreateTaskModel;
use Application\Tasks\Commands\CreateTask\ICreateTaskCommand;
use Application\Tasks\Queries\GetTaskById\IGetTaskByIdQuery;
use Domain\Tasks\Task;
use Service\Shared\Helpers\Helpers;

class CreateTaskForUserCommand implements ICreateTaskForUserCommand
{

    public function __construct(
        private ICreateTaskCommand $command,
        private IGetTaskByIdQuery $query
    )
    {
    }

    public function Execute(CreateTaskForUserModel $model)
    {
        $createModel = new CreateTaskModel(
            $model->user_id,
            $model->title,
            $model->description,
            $model->deadline,
            $model->image
        );

        return $this->command
                    ->Execute($createModel)
                    ->then(function(Task $task){
                        return $this->query->Execute($task->user_id,$task->id);
                    });
    }
}