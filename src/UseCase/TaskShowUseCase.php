<?php

namespace App\UseCase;

use App\Core\Repositories\TaskRepositoryInterface;
use App\Domain\Entities\Task;
use App\Domain\Outputs\TaskShowOutput;
use Core\Exceptions\NotFoundException;
use Core\Request\Request;

class TaskShowUseCase implements TaskShowUseCaseInterface
{
    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function handle(Request $request,$task)
    {
        $user = $request->getAuth();

        return $this->taskRepository
                    ->getTaskForUser($task,$user["id"])
                    ->then(function($task){
                        if(is_null($task))
                        {
                            throw new NotFoundException("Route not found");
                        }
                        $output = new TaskShowOutput(new Task($task));
                        return response($output->output());
                    });
    }

}