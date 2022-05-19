<?php
namespace App\Core\Repositories;

use App\Common\Repositories\Repository;
use React\MySQL\QueryResult;

class TaskRepository extends Repository implements TaskRepositoryInterface
{
    public function table(): string
    {
        return "tasks";
    }

    public function getTasksForUser($user_id)
    {
        $sql = <<<SQL
        SELECT * FROM `tasks` WHERE `user_id` = ? AND deleted_at is NULL ORDER BY id DESC
        SQL;
        return $this->query($sql , [$user_id])
                ->then(function (QueryResult $result){
                    return $result->resultRows;
                });
    }

}