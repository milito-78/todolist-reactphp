<?php

namespace App\Core\Controller\Task;

use App\Domain\Repositories\TaskRepositoryInterface;
use App\Domain\Repositories\UserRepositoryInterface;
use Core\Request\Controller;
use Core\Request\Request;

class TaskUpdateController extends Controller
{
    private UserRepositoryInterface $userRepository;
    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository,UserRepositoryInterface $userRepository)
    {
        $this->taskRepository = $taskRepository;
        $this->userRepository = $userRepository;
    }

    public function update(Request $request)
    {
        $token = $request->getHeader("Authorization");

        return $this->userRepository
                    ->findByToken($token[0]??"")
                    ->then(function($user)use($request){
                        if(!is_null($user)){
                            return $this->taskRepository
                                    ->update($user["id"],[
                                        "title"         => $request->title,
                                        "description"   => $request->description
                                    ])
                                    ->then(function($result){
                                        return response($result);
                                    });
                        }
                        
                        return response("Un authenticate",401);
                    });
    }
}