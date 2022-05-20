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
        $sql = <<<SQL
        SELECT * FROM `tasks` WHERE `user_id` = ? AND deleted_at is NULL ORDER BY id DESC
        SQL;
        return $this->query($sql , [$user_id])
                ->then(function (QueryResult $result){
                    return $result->resultRows;
                });
    }

    public function getTaskForUser($task_id,$user_id): PromiseInterface
    {
        $sql = <<<SQL
        SELECT * FROM `tasks` WHERE `id` = ? AND `user_id` = ? AND `deleted_at` is NULL ORDER BY `id` DESC LIMIT 1
        SQL;
        return $this->query($sql , [$task_id,$user_id])
                ->then(function (QueryResult $result)
                {
                    if (!@$result->resultRows[0])
                        return null;
                    return $result->resultRows[0];
                });
    }

}