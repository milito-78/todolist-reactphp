<?php
namespace Service\Users\ChangePassword;

use Application\Users\Commands\ChangePassword\IChangePasswordCommand;
use Application\Users\Queries\LoginUser\Exceptions\CredentialException;
use Service\Shared\Helpers\Helpers;
use Service\Shared\Request\Controller;
use Service\Shared\Request\Request;
use Service\Shared\Response\JsonResponse;

class ChangePasswordController extends Controller
{
    public function __construct(private IChangePasswordCommand $command)
    {
    }

    public function __invoke(Request $request)
    {
        $validated  = $this->validate($request);
        $user       = $request->getAuth();

        return $this->command
                    ->Execute(
                        $user->id,
                        $validated->currentPassword(),
                        $validated->password()
                    )->then(function(bool $result){
                        return Helpers::response([
                            "message" => "Password changed successfully",
                            "data" => null
                        ]);
                    })->otherwise(function(CredentialException $exception){
                        return Helpers::response([
                            "title"=> "Validation Failed!",
                            "errors"=> [
                                "current password is incorrect"
                            ]
                        ],JsonResponse::STATUS_UNPROCESSABLE_ENTITY);
                    });;
    }

    private function validate(Request $request): ChangePasswordRequest{
        $model = new ChangePasswordRequest($request);
        return $model->validate();
    }

}