<?php
namespace Application\Tasks\Queries\GetTasksForUserWithPaginate;

interface IGetTasksForUserWithPaginateQuery {
    public function Execute(GetTasksForUserWithPaginateModel $model);
}