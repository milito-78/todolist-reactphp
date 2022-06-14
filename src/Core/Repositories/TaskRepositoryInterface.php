<?php


namespace App\Core\Repositories;

use App\Common\Repositories\RepositoryInterface;

interface TaskRepositoryInterface extends RepositoryInterface
{
    public function getTasksForUser($user_id,$page);

    public function getTaskForUser($task_id,$user_id);
}