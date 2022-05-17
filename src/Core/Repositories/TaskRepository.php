<?php
namespace App\Core\Repositories;

use App\Common\Repsitories\Repository;
use React\MySQL\QueryResult;
use React\Promise\PromiseInterface;

class TaskRepository extends Repository implements TaskRepositoryInterface
{
    public function table(): string
    {
        return "tasks";
    }

    public function getTasksForUser($user_id)
    {
        $sql = <<<SQL
        SELECT * FROM `tasks` WHERE `user_id` = ?
        SQL;
        return $this->query($sql , [$user_id])
                ->then(function (QueryResult $result){
                    return $result->resultRows;
                });
    }

}