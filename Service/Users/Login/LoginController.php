<?php 
namespace Service\Users\Login;

use Application\Users\Queries\LoginUser\Exceptions\CredentialException;
use Application\Users\Queries\LoginUser\ILoginUserQuery;
use Domain\Users\User;
use Service\Shared\Helpers\Helpers;
use Service\Shared\Request\Controller;
use Service\Shared\Request\Request;
use Service\Users\Common\Resources\UserResource;

class LoginController extends Controller
{
    public function __construct(private ILoginUserQuery $query)
    {
    }
    
    public function __invoke(Request $request)
    {
        $validated = $this->validate($request);

        return $this->query
                    ->Execute($validated->email(),$validated->password())
                    ->then(function(User $user){
                        return Helpers::response($this->response($user));
                    },function(CredentialException $exception){
                        return Helpers::response([
                            "title"=> "Validation Failed!",
                            "errors"=> [
                               $exception->getMessage()
                            ]
                        ],422);
                    });
    }

    private function validate(Request $request): LoginRequest{
        $model = new LoginRequest($request);
        return $model->validate();
    }

    private function response($user){
        return [
            "message" => "Login successfully",
            "data" => [
                "user" => (new UserResource($user))->toArray()
            ]
        ];
    }

}