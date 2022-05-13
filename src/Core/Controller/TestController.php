<?php
namespace App\Core\Controller;

use Core\Request\Controller;

class TestController extends Controller
{
    public function __invoke(){
        return "Hello invoke";
    }
}