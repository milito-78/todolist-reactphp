<?php
namespace App\Core\Repositories;

use App\Common\Repositories\Repository;
use NilPortugues\Sql\QueryBuilder\Syntax\OrderBy;
use React\MySQL\QueryResult;
use React\Promise\PromiseInterface;

class TaskRepository extends Repository implements TaskRepositoryInterface
{
    private int $per_page = 20;

    public function table(): string
    {
        return "tasks";
    }

    public function getAllTasksForUser($user_id,$page): PromiseInterface
    {
        return $this->_query()
            ->where()
            ->equals("user_id",$user_id)
            ->isNull("deleted_at")
            ->end()
            ->orderBy("ISNULL(tasks.deadline)",OrderBy::ASC,'')
            ->orderBy("deadline")
            ->orderBy("created_at")
            ->simplePaginate($this->per_page,$page);
    }

    public function getTaskForUser($task_id,$user_id): PromiseInterface
    {
        return $this->_query()->where()
            ->equals("user_id",$user_id)
            ->equals("id",$task_id)
            ->end()
            ->first();
    }

    public function getDeadlineTasksForUser($user_id, $page): PromiseInterface
    {
        return $this->_query()
            ->where()
            ->equals("user_id",$user_id)
            ->isNotNull("deadline")
            ->isNull("deleted_at")
            ->end()
            ->orderBy("deadline")
            ->simplePaginate($this->per_page,$page);
    }

    public function getByTimeTasksForUser($user_id, $page): PromiseInterface
    {
        return $this->_query()
            ->where()
            ->equals("user_id",$user_id)
            ->between("deadline",date("Y-m-d")." 00:00:00" ,date("Y-m-d")." 23:59:59")
            ->isNull("deleted_at")
            ->end()
            ->orderBy("deadline")
            ->simplePaginate($this->per_page,$page);
    }
}