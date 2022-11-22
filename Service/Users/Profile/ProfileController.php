<?php
namespace Service\Users\Profile;

use Service\Shared\Helpers\Helpers;
use Service\Shared\Request\Controller;
use Service\Shared\Request\Request;
use Service\Users\Common\Resources\UserResource;

class ProfileController extends Controller
{
    public function __construct()
    {
    }
    
    public function __invoke(Request $request)
    {
        $user = $request->getAuth();
        return Helpers::response([
            "message" => "success",
            "data" => [
                "user" => (new UserResource($user))->toArray()
            ]
        ]);
    }

}