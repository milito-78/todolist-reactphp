<?php
namespace Application\Tasks\Queries\GetTasksWithPaginate;

interface GetByPaginateQueryInterface {
    public function Execute(GetByPaginateModel $model);
}