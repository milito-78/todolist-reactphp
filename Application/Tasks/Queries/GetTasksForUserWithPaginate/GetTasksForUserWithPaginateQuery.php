<?php
namespace Application\Tasks\Queries\GetTasksForUserWithPaginate;

use Application\Interfaces\Persistence\TaskRepositoryInterface;
use Domain\Tasks\Task;

class GetTasksForUserWithPaginateQuery implements IGetTasksForUserWithPaginateQuery
{

    public function __construct(private TaskRepositoryInterface $taskRepository)
    {
    }

    public function Execute(GetTasksForUserWithPaginateModel $model)
    {
        return $this->taskRepository
                    ->getByForUserPaginateQuery(
                        $model->getUserId(),
                        $model->getFilter(),
                        $model->getPage()
                    )
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