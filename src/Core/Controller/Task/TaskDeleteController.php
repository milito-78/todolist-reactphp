<?php

namespace App\Core\Controller\Task;

use App\Domain\Repositories\TaskRepositoryInterface;
use App\Domain\Repositories\UserRepositoryInterface;
use Core\Request\Controller;
use Core\Request\Request;
use React\MySQL\QueryResult;

class TaskDeleteController extends Controller
{
    private UserRepositoryInterface $userRepository;
    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository,UserRepositoryInterface $userRepository)
    {
        $this->taskRepository = $taskRepository;
        $this->userRepository = $userRepository;
    }

    public function destroy(Request $request,$task)
    {
        $token = $request->getHeader("Authorization");

        return $this->userRepository
                    ->findByToken($token[0]??"")
                    ->then(function($user) use ($task){
                        if(!is_null($user)){
                            return $this->taskRepository
                                    ->find($task)
                                    ->then(function($result) use($user,$task) {
                                        if($result["user_id"] == $user["id"]){
                                            return $this->taskRepository
                                                        ->delete($result["id"])
                                                        ->then(function(bool $result){
                                                            return response("Delete successfully");
                                                        });
                                        }
                                        return response("Not found",404);
                                    });
                        }
                        
                        return response("Un authenticate",401);
                    });
    }
}