<?php

namespace App\UseCase;

use App\Core\Repositories\TaskRepositoryInterface;
use App\Core\Repositories\UserRepositoryInterface;
use App\Domain\Entities\Task;
use App\Domain\Outputs\TaskIndexOutput;
use Core\Request\Request;

class TaskIndexUseCase implements TaskIndexUseCaseInterface
{

    private UserRepositoryInterface $userRepository;
    private TaskRepositoryInterface $taskRepository;


    public function __construct(UserRepositoryInterface $userRepository,TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
        $this->userRepository = $userRepository;
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