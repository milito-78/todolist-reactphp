<?php


namespace Service\Tasks\Controller;


use Service\Shared\Request\Request;

class TaskStoreController
{


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