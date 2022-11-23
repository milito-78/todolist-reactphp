<?php


namespace Application\Tasks\Commands\CreateTaskForUser;


interface ICreateTaskForUserCommand
{
    public function Execute(CreateTaskForUserModel $model);
}