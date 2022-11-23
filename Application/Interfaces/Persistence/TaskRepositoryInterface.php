<?php


namespace Application\Interfaces\Persistence;

use Application\Tasks\Queries\GetTasksWithPaginate\GetByPaginateModel;
use React\Promise\PromiseInterface;

interface TaskRepositoryInterface extends RepositoryInterface
{
    public function getByPaginateQuery(string $filter, int $page):PromiseInterface;

    public function getByForUserPaginateQuery(int $user, string $filter, int $page):PromiseInterface;

    public function getTaskForUser($task_id,$user_id):PromiseInterface;
}