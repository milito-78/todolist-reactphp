<?php
namespace Application\Tasks\Queries\GetTaskForUserById;



use React\Promise\PromiseInterface;

interface IGetTaskForUserByIdQuery
{
    public function Execute(int $user_id,int $task_id):PromiseInterface;
}