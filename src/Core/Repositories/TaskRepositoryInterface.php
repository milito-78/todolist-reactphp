<?php


namespace App\Core\Repositories;

use App\Infrastructure\Repositories\RepositoryInterface;

interface TaskRepositoryInterface extends RepositoryInterface
{
    public function getAllTasksForUser($user_id,$page);

    public function getDeadlineTasksForUser($user_id,$page);

    public function getByTimeTasksForUser($user_id,$page);

    public function getTaskForUser($task_id,$user_id);
}