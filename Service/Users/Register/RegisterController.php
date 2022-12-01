<?php
namespace Service\Users\Register;

use Application\Users\Commands\RegisterUser\Exceptions\UserExistsException;
use Application\Users\Commands\RegisterUser\RegisterUserModel;
use Application\Users\Commands\RegisterUser\IRegisterUserCommand;
use Domain\Users\User;
use Service\Shared\Helpers\Helpers;
use Service\Shared\Request\Controller;
use Service\Shared\Request\Request;
use Service\Shared\Response\JsonResponse;
use Service\Users\Common\Resources\UserResource;

class RegisterController extends Controller
{
    public function __construct(private IRegisterUserCommand $command)
    {
    }
    
    public function __invoke(Request $request)
    {
        $validated = $this->validate($request);

        $input = new RegisterUserModel(
            $validated->email(),
            $validated->password(),
            $validated->fullName()
        );

        return $this->command
                    ->Execute($input)
                    ->then(function(User $user){
                        return Helpers::response($this->response($user),JsonResponse::STATUS_CREATED);
                    },function(UserExistsException $exception){
                        return Helpers::response([
                            "title"=> "Validation Failed!",
                            "errors"=> [
                                "Email has been registered before"
                            ]
                        ],JsonResponse::STATUS_UNPROCESSABLE_ENTITY);
                    });
    }

    private function validate(Request $request): RegisterRequest{
        $model = new RegisterRequest($request);
        return $model->validate();
    }

    private function response($user){
        return [
            "message" => "Registry completed successfully",
            "data" => [
                "user" => (new UserResource($user))->toArray()
            ]
        ];
    }

}