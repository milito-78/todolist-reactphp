<?php
namespace Service\Users\Logout;

use Service\Shared\Helpers\Helpers;
use Service\Shared\Request\Controller;
use Service\Shared\Request\Request;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        return Helpers::response([
            "message" => "Logout completed successfully",
            "data" => null
        ]);
    }
}