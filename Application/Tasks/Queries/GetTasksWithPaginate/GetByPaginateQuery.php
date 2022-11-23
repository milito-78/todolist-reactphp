<?php
namespace Application\Tasks\Queries\GetTasksWithPaginate;

use Application\Interfaces\Persistence\TaskRepositoryInterface;
use Domain\Tasks\Task;

class GetByPaginateQuery implements IGetByPaginateQuery
{

    public function __construct(private TaskRepositoryInterface $taskRepository)
    {
    }

    public function Execute(GetByPaginateModel $model)
    {
        return $this->taskRepository
                    ->getByPaginateQuery($model)
                    ->then(function($tasks){
                        return $this->mapTasks($tasks);
                    });
    }


    private function mapTasks(array $tasks): array
    {
        $tasks["data"] = array_map(function ($task){
            return new Task($task);
        },$tasks["data"]);

        return $tasks;
    }
}