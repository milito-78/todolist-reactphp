<?php

namespace App\Core\Controller\Task;

use App\UseCase\TaskShowUseCaseInterface;
use Core\Request\Controller;
use Core\Request\Request;

class TaskShowController extends Controller
{
    private TaskShowUseCaseInterface $taskService;

    public function __construct(TaskShowUseCaseInterface $taskService)
    {
        $this->taskService = $taskService;
    }

    public function __invoke(Request $request,$task)
    {
        return $this->taskService->handle($request,$task);
    }
}