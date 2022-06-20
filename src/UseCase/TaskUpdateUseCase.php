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
                                    ->then(function($result)use ($task,$data){
                                        if ($data["image_path"] != $task["image_path"])
                                        {
                                            $this->sendImageDeleteSystemEvent($data["image_path"]);
                                            $this->sendFileDeleteSystemEvent($task["image_path"]);
                                        }
                                        return json_no_content();
                                    });
                    });
    }

    private function sendImageDeleteSystemEvent($image_path){
        if (!is_null($image_path) && !empty($image_path))
            emit("server","upload_clean",["image_path"=> $image_path]);
    }

    private function sendFileDeleteSystemEvent($image_path){
        if (!is_null($image_path) && !empty($image_path))
            emit("server","delete_file",["image_path"=> $image_path]);
    }

}