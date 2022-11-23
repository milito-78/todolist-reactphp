<?php
namespace Service\Tasks\TasksList;

use Application\Tasks\Queries\GetTasksWithPaginate\GetByPaginateModel;
use Application\Tasks\Queries\GetTasksWithPaginate\IGetByPaginateQuery;
use Domain\Tasks\Task;
use Service\Shared\Helpers\Helpers;
use Service\Shared\Request\Controller;
use Service\Shared\Request\Request;
use Service\Tasks\Common\Resources\TaskResource;

class TaskIndexController extends Controller
{

    public function __construct(private IGetByPaginateQuery $query)
    {
    }

    public function __invoke(Request $request)
    {
        $model = new GetByPaginateModel(
            (int)$request->getAuth()->id,
            (int)$request->input("page") ??1,
            (string) $request->input("filter") ?? ""
        );

        return $this->query->Execute($model)->then(function ($tasks){
            return Helpers::response($this->response($tasks));
        });
    }

    private function response($tasks) :array{
        $tasks["items"] = array_map(function (Task $task){
            return (new TaskResource( $task ))->toArray();
        },$tasks["data"]);
        unset($tasks["data"]);

        return [
            "message" => "success",
            "data" => $tasks
        ];
    }
}