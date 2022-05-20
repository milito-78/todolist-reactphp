<?php

namespace App\Core\Controller\Task;

use App\Domain\Inputs\TaskUpdateInput;
use App\UseCase\TaskUpdateUseCaseInterface;
use Core\Request\Controller;
use Core\Request\Request;

class TaskUpdateController extends Controller
{
    private TaskUpdateUseCaseInterface $taskService;

    public function __construct(TaskUpdateUseCaseInterface $taskService)
    {
        $this->taskService = $taskService;
    }

    public function __invoke(Request $request,$task)
    {
        
        $input = new TaskUpdateInput($request);
        $input->validate();
        
        return $this->taskService->handle($input,$task);

    }
}