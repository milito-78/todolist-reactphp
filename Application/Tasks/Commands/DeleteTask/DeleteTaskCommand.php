<?php 
namespace Application\Tasks\Commands\DeleteTask;

use Application\Interfaces\Persistence\TaskRepositoryInterface;
use Application\Tasks\Queries\GetTaskById\IGetTaskByIdQuery;
use Domain\Tasks\Task;
use React\Promise\PromiseInterface;
use Service\Shared\Helpers\Helpers;

use function React\Promise\reject;

class DeleteTaskCommand implements IDeleteTaskCommand{
    
    /**
     */
    public function __construct(
        private IGetTaskByIdQuery $query,
        private TaskRepositoryInterface $taskRepository
    ) {
    }

	/**
	 * @param int $user_id
	 * @param int $task_id
	 * @return PromiseInterface
	 */
	public function Execute(int $task): PromiseInterface {
        return $this->query
                    ->Execute($task)->then(function(Task $task){
                        $this->taskRepository
                            ->delete($task->id)
                            ->then(function(bool $result) use ($task){
                                if($result){
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