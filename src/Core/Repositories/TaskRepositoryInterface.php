<?php


namespace App\Core\Repositories;


use App\Common\Repsitories\RepositoryInterface;

interface TaskRepositoryInterface extends RepositoryInterface
{
    public function getTasksForUser($user_id);
}