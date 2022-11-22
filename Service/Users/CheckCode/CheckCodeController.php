<?php
namespace Service\Users\CheckCode;

use Application\Codes\Queries\GetCodeByToken\Exceptions\CodeExpiredException;
use Application\Users\Queries\CheckForgetPasswordCode\ICheckForgetPasswordCodeQuery;
use Application\Users\Queries\GetUserByEmail\Exceptions\NotFoundUserException;
use Service\Shared\Helpers\Helpers;
use Service\Shared\Request\Controller;
use Service\Shared\Request\Request;

class CheckCodeController extends Controller
{
    public function __construct(private ICheckForgetPasswordCodeQuery $query)
    {
    }

    public function __invoke(Request $request)
    {
        $validated = $this->validate($request);

        return $this->query
                    ->Execute(
                        $validated->token(),
                        $validated->email(),
                        $validated->code()
                    )->then(function(bool $result){
                        if($result)
                            return Helpers::response([
                                "message" => "code is valid",
                                "data" => [
                                    "check" => true
                                ]
                            ]);
                        return Helpers::response([
                            "message" => "code is invalid",
                            "data" => [
                                "check" => false
                            ]
                        ]);
                    })->otherwise(function(CodeExpiredException $exception){
                        return Helpers::response([
                            "title"=> "Validation Failed!",
                            "errors"=> [
                                "verify code has expired"
                            ]
                        ],422);
                    })->otherwise(function(NotFoundUserException $exception){
                        return Helpers::response([
                            "title"=> "Validation Failed!",
                            "errors"=> [
                                "Email has not registered before"
                            ]
                        ],422);
                    });

    }


    private function validate(Request $request): CheckCodeRequest{
        $model = new CheckCodeRequest($request);
        return $model->validate();
    }
}