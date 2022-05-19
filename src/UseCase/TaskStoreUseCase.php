<?php

namespace App\UseCase;

use App\Core\Repositories\TaskRepositoryInterface;
use App\Domain\Entities\Task;
use App\Domain\Inputs\TaskStoreInput;
use App\Domain\Outputs\TaskStoreOutput;

class TaskStoreUseCase implements TaskStoreUseCaseInterface
{
    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository) 
    {
        $this->taskRepository = $taskRepository;
    }

    public function handle(TaskStoreInput $input)
    {
        $data = $input->validated();
    
        return $this->taskRepository
                    ->create($data)
                    ->then(function($task){
                        $output = new TaskStoreOutput(new Task($task));
                        return response($output->output(),201);
                    });
                    
    }

}