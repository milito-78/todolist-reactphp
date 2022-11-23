<?php
namespace Application\Tasks\Queries\GetTasksWithPaginate;

interface IGetByPaginateQuery {
    public function Execute(GetByPaginateModel $model);
}