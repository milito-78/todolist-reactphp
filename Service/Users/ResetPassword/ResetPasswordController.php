<?php
namespace Service\Users\ResetPassword;

use Application\Codes\Queries\GetCodeByToken\Exceptions\CodeExpiredException;
use Application\Users\Commands\ResetPassword\IResetPasswordCommand;
use Application\Users\Commands\ResetPassword\ResetPasswordModel;
use Application\Users\Queries\GetUserByEmail\Exceptions\NotFoundUserException;
use Service\Shared\Helpers\Helpers;
use Service\Shared\Request\Controller;
use Service\Shared\Request\Request;
use Service\Shared\Response\JsonResponse;

class ResetPasswordController extends Controller
{
    public function __construct(
        private IResetPasswordCommand $command
    )
    {
    }

    public function __invoke(Request $request)
    {
        $validated = $this->validate($request);

        $input = new ResetPasswordModel(
            $validated->email(),
            $validated->token(),
            $validated->code(),
            $validated->password()
        );


        return $this->command
                    ->Execute($input)
                    ->then(function(bool $res){
                        return Helpers::response([
                            "message" => "Password reset successfully",
                            "data" => null
                        ]);
                    })->otherwise(function(bool $res){
                        return Helpers::response([
                            "title"=> "Validation Failed!",
                            "errors"=> [
                                "verify code is expired"
                            ],
                        ],JsonResponse::STATUS_UNPROCESSABLE_ENTITY);
                    })->otherwise(function(CodeExpiredException $exception){
                        return Helpers::response([
                            "title"=> "Validation Failed!",
                            "errors"=> [
                                "verify code has expired"
                            ]
                        ],JsonResponse::STATUS_UNPROCESSABLE_ENTITY);
                    })->otherwise(function(NotFoundUserException $exception){
                        return Helpers::response([
                            "title"=> "Validation Failed!",
                            "errors"=> [
                                "Email has not registered before"
                            ]
                        ],JsonResponse::STATUS_UNPROCESSABLE_ENTITY);
                    });
    }

    private function validate(Request $request): ResetPasswordRequest{
        $model = new ResetPasswordRequest($request);
        return $model->validate();
    }
}