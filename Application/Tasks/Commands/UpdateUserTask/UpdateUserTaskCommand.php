<?php
namespace Application\Tasks\Commands\UpdateUserTask;

use Application\Interfaces\Persistence\TaskRepositoryInterface;
use Application\Tasks\Queries\GetTaskForUserById\IGetTaskForUserByIdQuery;
use Domain\Tasks\Task;
use React\Promise\PromiseInterface;
use Service\Shared\Helpers\Helpers;

class UpdateUserTaskCommand implements IUpdateUserTaskCommand{
    /**
     */
    public function __construct(
        private IGetTaskForUserByIdQuery $query,
        private TaskRepositoryInterface $taskRepository
    ){
    }

	/**
	 * @param int $user
	 * @param int $task
	 * @param UpdateUserTaskModel $model
	 * @return PromiseInterface
	 */
	public function Execute(int $user, int $task, UpdateUserTaskModel $model): PromiseInterface {

        return $this->query
                    ->Execute($user,$task)
                    ->then(function(Task $task) use ($model){
                        return $this->taskRepository
                                    ->update($task->id,$model->toArray())
                                    ->then(function ($res) use($task,$model) {
                                        if ($model->image != $task->image_path)
                                        {
                                            $this->sendImageDeleteSystemEvent($model->image);
                                            $this->sendFileDeleteSystemEvent($task->image_path);
                                        }
                                        return true;
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