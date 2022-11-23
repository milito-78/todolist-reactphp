<?php
namespace Application\Tasks\Commands\DeleteTask;
use React\Promise\PromiseInterface;

interface IDeleteTaskCommand {
    public function Execute(int $task_id): PromiseInterface;
}