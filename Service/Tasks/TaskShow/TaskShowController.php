<?php
namespace Service\Tasks\TaskShow;

use Application\Tasks\Queries\GetTaskById\Exceptions\NotFoundTaskException;
use Application\Tasks\Queries\GetTaskById\IGetTaskByIdQuery;
use Domain\Tasks\Task;
use Service\Shared\Exceptions\NotFoundException;
use Service\Shared\Helpers\Helpers;
use Service\Shared\Request\Controller;
use Service\Shared\Request\Request;
use Service\Tasks\Common\Resources\TaskResource;

class TaskShowController extends Controller
{

    public function __construct(private IGetTaskByIdQuery $query)
    {
    }

    public function __invoke(Request $request,$task)
    {
        return $this->query
            ->Execute($request->getAuth()->id,(int)$task)
            ->then(function (Task $task){
                return Helpers::response([
                    "message" => "success",
                    "data" => (new TaskResource($task))->toArray()
                ]);
            },function (NotFoundTaskException $exception){
                throw new NotFoundException("Route not found");
            });
    }
}