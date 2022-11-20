<?php
namespace Application\Tasks\Queries\GetTasksWithPaginate;

use Application\Interfaces\Persistence\TaskRepositoryInterface;

class GetByPaginateQuery implements GetByPaginateQueryInterface
{
    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function Execute(GetByPaginateModel $model)
    {
        return $this->taskRepository->getByPaginateQuery($model);
    }
}