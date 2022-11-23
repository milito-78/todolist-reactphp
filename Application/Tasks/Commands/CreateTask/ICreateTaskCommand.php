<?php
namespace Application\Tasks\Commands\CreateTask;

use React\Promise\PromiseInterface;

interface ICreateTaskCommand{
    public function Execute(CreateTaskModel $model) :PromiseInterface;
}