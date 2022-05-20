<?php

namespace App\UseCase;

use App\Core\Repositories\TaskRepositoryInterface;
use App\Domain\Inputs\TaskUpdateInput;
use Core\Exceptions\NotFoundException;

class TaskUpdateUseCase implements TaskUpdateUseCaseInterface
{
    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository) 
    {
        $this->taskRepository = $taskRepository;
    }

    public function handle(TaskUpdateInput $input,$task)
    {
        $data = $input->validated();
        $user = $input->request()->getAuth();
        
        return $this->taskRepository
                    ->getTaskForUser($task,$user["id"])
                    ->then(function($task) use ($data){
                        if(is_null($task))
                        {
                            throw new NotFoundException("Route not found");
                        }

                        return $this->taskRepository
                                    ->update($task["id"],$data)
                                    ->then(function($result){
                                        return response(null,204);
                                    });
                    });
        
        
                    
    }

}