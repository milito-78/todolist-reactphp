<?php
namespace App\Core\Repositories;

use App\Common\Repositories\Repository;
use React\MySQL\QueryResult;
use React\Promise\PromiseInterface;

class TaskRepository extends Repository implements TaskRepositoryInterface
{
    public function table(): string
    {
        return "tasks";
    }

    public function getTasksForUser($user_id): PromiseInterface
    {
        return $this->_query()->where()->equals("user_id",$user_id)->end()->get();
    }

    public function getTaskForUser($task_id,$user_id): PromiseInterface
    {
        return $this->_query()->where()
            ->equals("user_id",$user_id)
            ->equals("id",$task_id)
            ->end()
            ->first();
    }

}