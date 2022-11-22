<?php
namespace Service\Options\Splash;

use Application\Users\Queries\GetUserByToken\GetByTokenQueryInterface;
use Domain\Users\User;
use Service\Shared\Helpers\Helpers;
use Service\Shared\Request\Controller;
use Service\Shared\Request\Request;
use Service\Users\Common\Resources\UserResource;

class SplashController extends Controller{
    public function __construct(private GetByTokenQueryInterface $query)
    {
    }

    public function __invoke(Request $request) {
        return $this->query
                ->Execute(Helpers::getAuthToken($request))
                ->then(function(User $user){
                    $option = array_merge($this->data(),[
                        "user" => (new UserResource($user))->toArray()
                    ]);
                    
                    return Helpers::response([
                        "message" => "success",
                        "data" => [
                            "option" => $option
                        ]
                    ]);
                },function(){
                    return Helpers::response([
                        "message" => "success",
                        "data" => [
                            "option" => $this->data()
                        ]
                    ]);
                });
    
    }


    private function data(){
        return [
            "user"                  => null,
            "timestamp"             => time(),
            "version"               => "1.0",
            "update_version"        => "1.0",
            "api_version"           => "1.0",
            "is_essential_update"   => false
        ];
    }
}