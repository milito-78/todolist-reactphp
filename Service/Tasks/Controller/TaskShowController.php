<?php
namespace Service\Tasks\Controller;

use Application\Tasks\Queries\GetTaskById\GetTaskByIdQueryInterface;
use Service\Shared\Exceptions\NotFoundException;
use Service\Shared\Request\Controller;
use Service\Shared\Request\Request;

class TaskShowController extends Controller
{
    private GetTaskByIdQueryInterface $getTaskByIdQuery;

    public function __construct(GetTaskByIdQueryInterface $getTaskByIdQuery)
    {
        $this->getTaskByIdQuery = $getTaskByIdQuery;
    }

    public function __invoke(Request $request,$task)
    {

        return $this->getTaskByIdQuery
            ->Execute($request->getAuth()->id,(int)$task)
            ->then(function ($task){
                return [
                    "data" => $task->toArray()
                ];
            },function (){
                throw new NotFoundException("Route not found");
            });
    }
}