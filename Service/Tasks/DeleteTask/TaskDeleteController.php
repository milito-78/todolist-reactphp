<?php
namespace Service\Tasks\DeleteTask;

use Application\Tasks\Commands\DeleteTaskForUser\IDeleteTaskForUserCommand;
use Application\Tasks\Queries\GetTaskById\Exceptions\NotFoundTaskException;
use React\MySQL\Exception;
use Service\Shared\Exceptions\NotFoundException;
use Service\Shared\Helpers\Helpers;
use Service\Shared\Request\Controller;
use Service\Shared\Request\Request;

class TaskDeleteController extends Controller
{
    public function __construct(
        private IDeleteTaskForUserCommand $command
    )
    {
    }

    public function __invoke(Request $request,$task)
    {
        return $this->command
                    ->Execute($request->getAuth()->id,(int)$task)
                    ->then(function(bool $result){
                        if ($result)
                            return  Helpers::response([
                                    "message" => "Task deleted successfully",
                            ]);
                        throw new Exception("Error during delete task. Please try again later");
                    },function (NotFoundTaskException $exception){
                        throw new NotFoundException("Route not found");
                    });
    }
}