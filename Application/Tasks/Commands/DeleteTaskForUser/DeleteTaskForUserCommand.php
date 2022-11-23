<?php
namespace Application\Tasks\Commands\DeleteTaskForUser;

use Application\Interfaces\Persistence\TaskRepositoryInterface;
use Application\Tasks\Queries\GetTaskForUserById\IGetTaskForUserByIdQuery;
use Domain\Tasks\Task;
use React\Promise\PromiseInterface;
use Service\Shared\Helpers\Helpers;

use function React\Promise\reject;

class DeleteTaskForUserCommand implements IDeleteTaskForUserCommand{
    public function __construct(
        private IGetTaskForUserByIdQuery $query,
        private TaskRepositoryInterface $taskRepository
    )
    {
        
    }

    public function Execute(int $user_id,int $task_id) : PromiseInterface{
        return $this->query
                    ->Execute($user_id,$task_id)
                    ->then(function(Task $task){
                        return $this->taskRepository
                                    ->delete($task->id)
                                    ->then(function(bool $result) use ($task){
                                        if($result)
                                        {
                                            $this->sendImageDeleteSystemEvent($task->image_path);
                                            $this->sendFileDeleteSystemEvent($task->image_path);
                                            return true;
                                        }
                                        return reject(false);
                                    });
                    });
    }

    private function sendImageDeleteSystemEvent($image_path){
        if (!is_null($image_path) && !empty($image_path))
            Helpers::emit("server","upload_clean",["image_path"=> $image_path]);
    }

    private function sendFileDeleteSystemEvent($image_path){
        if (!is_null($image_path) && !empty($image_path))
            Helpers::emit("server","delete_file",["image_path"=> $image_path]);
    }
}