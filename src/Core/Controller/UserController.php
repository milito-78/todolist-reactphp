<?php


namespace App\Core\Controller;


use App\Domain\Repositories\UserRepositoryInterface;
use Core\Request\Controller;
use Core\Request\Request;
use React\MySQL\QueryResult;
use Throwable;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {

        return $this->userRepository->findByEmail("test@email.com")
            ->then(function (QueryResult $result){
                if (empty($result->resultRows)) {
                    throw new \Exception("Not found");
                }
                
                return response($result->resultRows[0]);
            })
            ->otherwise(function (Throwable $throwable){
                echo $throwable->getMessage();
                return response("Error",500);
            });
    }

}