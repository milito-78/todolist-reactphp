<?php
namespace Service\Tasks\UpdateTask;

use Application\Tasks\Commands\UpdateUserTask\IUpdateUserTaskCommand;
use Application\Tasks\Commands\UpdateUserTask\UpdateUserTaskModel;
use Application\Tasks\Queries\GetTaskById\Exceptions\NotFoundTaskException;
use Exception;
use Service\Shared\Exceptions\NotFoundException;
use Service\Shared\Helpers\Helpers;
use Service\Shared\Request\Controller;
use Service\Shared\Request\Request;

class TaskUpdateController extends Controller
{
    public function __construct(
        private IUpdateUserTaskCommand $command
    )
    {
    }

    public function __invoke(Request $request,$task)
    {
        $validated = $this->validate($request);
        $input = new UpdateUserTaskModel(
            $validated->title(),
            $validated->description(),
            $validated->deadline(),
            $validated->image()
        );

        return $this->command
                    ->Execute($request->getAuth()->id,(int)$task,$input)
                    ->then(function(bool $result){
                        if ($result)
                            return  Helpers::response([
                                    "message" => "Task update successfully",
                            ]);
                        throw new Exception("Error during update task. Please try again later");
                    },function (NotFoundTaskException $exception){
                        throw new NotFoundException("Route not found");
                    });
    }

    private function validate(Request $request): TaskUpdateRequest{
        $model = new TaskUpdateRequest($request);
        return $model->validate();
    }

}