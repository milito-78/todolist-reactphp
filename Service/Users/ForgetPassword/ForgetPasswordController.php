<?php
namespace Service\Users\ForgetPassword;

use Application\Codes\Commands\CreateCode\SendBeforeModel;
use Application\Codes\Commands\SaveCode\SaveCodeModel;
use Application\Users\Commands\ForgetPassword\IForgetPasswordUserCommand;
use Application\Users\Queries\GetUserByEmail\Exceptions\NotFoundUserException;
use Service\Shared\Helpers\Helpers;
use Service\Shared\Request\Controller;
use Service\Shared\Request\Request;

class ForgetPasswordController extends Controller
{

    public function __construct(private IForgetPasswordUserCommand $query)
    {
    }
    
    public function __invoke(Request $request)
    {
        $validated = $this->validate($request);

        return $this->query
                    ->Execute($validated->email())
                    ->then(function(SaveCodeModel $save){
                        return Helpers::response($this->response($save),202);
                    })
                    ->otherwise(function(SendBeforeModel $before){
                        return Helpers::response($this->beforeResponse($before),200);
                    })
                    ->otherwise(function(NotFoundUserException $exception){
                        return Helpers::response([
                            "title"=> "Validation Failed!",
                            "errors"=> [
                                "Email has not registered before"
                            ]
                        ],422);
                    });
    }


    private function validate(Request $request): ForgetPasswordRequest{
        $model = new ForgetPasswordRequest($request);
        return $model->validate();
    }

    private function beforeResponse(SendBeforeModel $before){
        return [
            "message" => "Verify code has been sent for you before",
            "data" => [
                "token" => $before->token,
                "expire" => $before->expire
            ]
        ];
    }
    private function response(SaveCodeModel $save){
        return [
            "message" => "Verify code has been sent successfully",
            "data" => [
                "token" => $save->token,
                "expire" => $save->expire
            ]
        ];
    }

}