<?php

namespace App\Core\Controller\Task;

use App\UseCase\TaskDeleteUseCaseInterface;
use Core\Request\Controller;
use Core\Request\Request;

class TaskDeleteController extends Controller
{
    private TaskDeleteUseCaseInterface $taskService;

    public function __construct(TaskDeleteUseCaseInterface $taskService)
    {
        $this->taskService = $taskService;
    }

    public function __invoke(Request $request,$task)
    {
        return $this->taskService->handle($request,$task);
    }
}