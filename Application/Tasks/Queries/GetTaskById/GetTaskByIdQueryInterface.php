<?php


namespace Application\Tasks\Queries\GetTaskById;


interface GetTaskByIdQueryInterface
{
    public function Execute(int $user_id,int $task_id);
}