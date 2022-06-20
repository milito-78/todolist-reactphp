<?php

namespace App\UseCase;

use App\Core\Repositories\TaskRepositoryInterface;
use App\Domain\Entities\Task;
use App\Domain\Outputs\TaskIndexOutput;
use Core\Exceptions\ValidationException;
use Core\Request\Request;

class TaskIndexUseCase implements TaskIndexUseCaseInterface
{

    private TaskRepositoryInterface $taskRepository;


    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function handle(Request $request)
    {
        $user   = $request->getAuth();
        $filter = $request->input("filter");
        $page   = $request->input("page")??1;

        if (!is_null($filter) && !empty($filter) && !in_array($filter,["all", "deadline", "time"]))
        {
            var_dump($filter);
            throw new ValidationException("Unknown filter value ",422);
        }

        if (is_null($filter) || empty($filter) || $filter == "all")
            $result = $this->taskRepository->getAllTasksForUser($user["id"],$page);
        if ($filter == "deadline")
            $result = $this->taskRepository->getDeadlineTasksForUser($user["id"],$page);
        if ($filter == "time")
            $result = $this->taskRepository->getByTimeTasksForUser($user["id"],$page);

        return $result->then(function($tasks){
            $tasks = $this->mapTasks($tasks);
            $output = new TaskIndexOutput($tasks);
            return response($output->output());
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