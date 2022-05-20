<?php

namespace App\UseCase;

use App\Core\Repositories\TaskRepositoryInterface;
use App\Domain\Entities\Task;
use App\Domain\Outputs\TaskIndexOutput;
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
        $user = $request->getAuth();

        return $this->taskRepository
                    ->getTasksForUser($user["id"])
                    ->then(function($tasks){
                        $tasks = $this->mapTasks($tasks);
                        $output = new TaskIndexOutput($tasks);
                        return response($output->output());
                    });
    }

    private function mapTasks(array $tasks)
    {
        return array_map(function ($task){
            return new Task($task);
        },$tasks);
    }
}