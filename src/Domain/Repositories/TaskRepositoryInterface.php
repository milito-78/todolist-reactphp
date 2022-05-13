<?php


namespace App\Domain\Repositories;


use App\Domain\Context\RepositoryInterface;

interface TaskRepositoryInterface extends RepositoryInterface
{
    public function getTasksForUser($user_id);
}