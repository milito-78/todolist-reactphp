<?php


namespace Application\Tasks\Queries\GetTaskById;

use React\Promise\PromiseInterface;

interface IGetTaskByIdQuery
{
    public function Execute(int $user_id,int $task_id):PromiseInterface;
}