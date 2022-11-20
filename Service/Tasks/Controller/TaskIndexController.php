<?php
namespace Service\Tasks\Controller;

use Application\Tasks\Queries\GetTasksWithPaginate\GetByPaginateModel;
use Application\Tasks\Queries\GetTasksWithPaginate\GetByPaginateQueryInterface;
use Domain\Tasks\Task;
use Service\Shared\Request\Controller;
use Service\Shared\Request\Request;

class TaskIndexController extends Controller
{
    private GetByPaginateQueryInterface $getByPaginateQuery;

    public function __construct(GetByPaginateQueryInterface $getByPaginateQuery)
    {
        $this->getByPaginateQuery = $getByPaginateQuery;
    }

    public function __invoke(Request $request)
    {
        $model = new GetByPaginateModel(
            (int)$request->getAuth()->id,
            (int)$request->input("page") ??1,
            (string) $request->input("filter") ?? ""
        );

        return $this->getByPaginateQuery->Execute($model)->then(function ($tasks){
            $tasks["data"] = array_map(function (Task $task){
                return $task->toArray();
            },$tasks["data"]);

            return $tasks;
        });
    }
}