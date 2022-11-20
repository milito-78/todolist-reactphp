<?php


namespace Application\Tasks\Commands\CreateTaskForUser;


interface CreateTaskForUserCommandInterface
{
    public function Execute(CreateTaskForUserModel $model);
}