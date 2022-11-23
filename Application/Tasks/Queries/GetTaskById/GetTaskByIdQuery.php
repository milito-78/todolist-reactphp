<?php
namespace Application\Tasks\Queries\GetTaskById;


use Application\Interfaces\Persistence\TaskRepositoryInterface;
use Application\Tasks\Queries\GetTaskById\Exceptions\NotFoundTaskException;
use Domain\Tasks\Task;
use React\Promise\PromiseInterface;

use function React\Promise\reject;

class GetTaskByIdQuery implements IGetTaskByIdQuery
{

    public function __construct(private TaskRepositoryInterface $taskRepository)
    {
    }

    public function Execute(int $user_id, int $task_id) : PromiseInterface
    {
        return $this->taskRepository
                    ->getTaskForUser($task_id,$user_id)
                    ->then(function ($data){
                        if ($data)
                            return new Task($data);
                        return reject(new NotFoundTaskException);
                    });
    }
}