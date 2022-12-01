<?php
namespace Service\Tasks\CreateTask;

use Application\Tasks\Commands\CreateTaskForUser\CreateTaskForUserModel;
use Application\Tasks\Commands\CreateTaskForUser\ICreateTaskForUserCommand;
use Domain\Tasks\Task;
use Service\Shared\Helpers\Helpers;
use Service\Shared\Request\Controller;
use Service\Shared\Request\Request;
use Service\Shared\Response\JsonResponse;
use Service\Tasks\Common\Resources\TaskResource;

class TaskStoreController extends Controller
{
    public function __construct(private ICreateTaskForUserCommand $command)
    {
    }

    public function __invoke(Request $request)
    {
        $validated = $this->validate($request);

        $input = new CreateTaskForUserModel(
            $request->getAuth()->id,
            $validated->title(),
            $validated->description(),
            $validated->deadline(),
            $validated->image()
        );

        return $this->command
                    ->Execute($input)
                    ->then(function(Task $task){
                        return Helpers::response($this->response($task),JsonResponse::STATUS_CREATED);
                    });
    }

    private function validate(Request $request): TaskStoreRequest{
        $model = new TaskStoreRequest($request);
        return $model->validate();
    }

    private function response($task){
        return [
            "message" => "Task created successfully",
            "data" => [
                "task" => (new TaskResource($task))->toArray()
            ]
        ];
    }
}