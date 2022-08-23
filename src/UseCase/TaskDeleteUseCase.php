<?php

namespace App\UseCase;

use App\Core\Repositories\TaskRepositoryInterface;
use Core\Exceptions\NotFoundException;
use Core\Request\Request;
use Exception;

class TaskDeleteUseCase implements TaskDeleteUseCaseInterface
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
                        return $this->taskRepository
                                    ->delete($task["id"])
                                    ->then(function(bool $result) use ($task){
                                        if($result)
                                        {
                                            $this->sendImageDeleteSystemEvent($task["image_path"]);
                                            $this->sendFileDeleteSystemEvent($task["image_path"]);

                                            return response([
                                                "message" => "Task deleted successfully"
                                            ],200);
                                        }
                                        throw new Exception("Error during delete task");
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