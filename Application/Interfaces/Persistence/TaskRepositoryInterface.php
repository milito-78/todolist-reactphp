<?php


namespace Application\Interfaces\Persistence;

use Application\Interfaces\Persistence\RepositoryInterface;

interface TaskRepositoryInterface extends RepositoryInterface
{
    public function getAllTasksForUser($user_id,$page);

    public function getDeadlineTasksForUser($user_id,$page);

    public function getByTimeTasksForUser($user_id,$page);

    public function getTaskForUser($task_id,$user_id);
}