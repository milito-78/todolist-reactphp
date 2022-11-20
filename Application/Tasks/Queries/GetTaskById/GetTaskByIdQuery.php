<?php


namespace Application\Tasks\Queries\GetTaskById;


use Application\Interfaces\Persistence\TaskRepositoryInterface;

class GetTaskByIdQuery implements GetTaskByIdQueryInterface
{
    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function Execute(int $user_id, int $task_id)
    {
        return $this->taskRepository->getTaskForUser($task_id,$user_id);
    }
}