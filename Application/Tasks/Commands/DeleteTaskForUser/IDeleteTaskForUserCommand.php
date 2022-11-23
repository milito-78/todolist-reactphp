<?php
namespace Application\Tasks\Commands\DeleteTaskForUser;

use React\Promise\PromiseInterface;

interface IDeleteTaskForUserCommand{
    public function Execute(int $user_id,int $task_id) : PromiseInterface;
}