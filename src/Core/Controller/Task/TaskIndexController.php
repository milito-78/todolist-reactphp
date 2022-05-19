<?php

namespace App\Core\Controller\Task;

use App\UseCase\TaskIndexUseCaseInterface;
use Core\Request\Controller;
use Core\Request\Request;

class TaskIndexController extends Controller
{
    private TaskIndexUseCaseInterface $taskService;

    public function __construct(TaskIndexUseCaseInterface $taskService)
    {
        $this->taskService = $taskService;
    }

    public function __invoke(Request $request)
    {
        return $this->taskService->handle($request);
    }
}