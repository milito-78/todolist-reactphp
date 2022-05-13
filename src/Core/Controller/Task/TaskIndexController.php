<?php

namespace App\Core\Controller\Task;

use App\Domain\Repositories\TaskRepositoryInterface;
use App\Domain\Repositories\UserRepositoryInterface;
use Core\Request\Controller;
use Core\Request\Request;

class TaskIndexController extends Controller
{
    private UserRepositoryInterface $userRepository;
    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository,UserRepositoryInterface $userRepository)
    {
        $this->taskRepository = $taskRepository;
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $token = $request->getHeader("Authorization");

        return $this->userRepository
                    ->findByToken($token[0]??"")
                    ->then(function($user){
                        if(!is_null($user)){
                            return $this->taskRepository
                                    ->getTasksForUser($user["id"])
                                    ->then(function($result){
                                        return response($result);
                                    });
                        }
                        
                        return response("Un authenticate",401);
                    });
    }
}