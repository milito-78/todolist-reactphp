<?php


namespace Application\Tasks\Commands\CreateTaskForUser;


use Application\Interfaces\Persistence\TaskRepositoryInterface;

class CreateTaskForUserCommand implements CreateTaskForUserCommandInterface
{
    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function Execute(CreateTaskForUserModel $model)
    {

    }
}