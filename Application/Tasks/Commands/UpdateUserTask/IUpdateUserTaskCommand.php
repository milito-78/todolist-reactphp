<?php
namespace Application\Tasks\Commands\UpdateUserTask;

use React\Promise\PromiseInterface;

interface IUpdateUserTaskCommand{
    public function Execute(int $user, int $task, UpdateUserTaskModel $model):PromiseInterface;
}