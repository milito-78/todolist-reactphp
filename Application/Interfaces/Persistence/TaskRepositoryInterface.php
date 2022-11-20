<?php


namespace Application\Interfaces\Persistence;

use Application\Tasks\Queries\GetTasksWithPaginate\GetByPaginateModel;
use React\Promise\PromiseInterface;

interface TaskRepositoryInterface extends RepositoryInterface
{
    public function getByPaginateQuery(GetByPaginateModel $model):PromiseInterface;

    public function getTaskForUser($task_id,$user_id):PromiseInterface;
}