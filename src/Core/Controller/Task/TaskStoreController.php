<?php

namespace App\Core\Controller\Task;

use App\Domain\Inputs\TaskStoreInput;
use App\UseCase\TaskStoreUseCaseInterface;
use Core\Request\Controller;
use Core\Request\Request;

class TaskStoreController extends Controller
{
    private TaskStoreUseCaseInterface $taskService;

    public function __construct(TaskStoreUseCaseInterface $taskService)
    {
        $this->taskService = $taskService;
    }

    public function __invoke(Request $request)
    {
        $input = new TaskStoreInput($request);
        return $this->taskService->handle($input); 
    }
}