<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\BaseController;

class TestController extends BaseController
{
    public function test1()
    {
        return "Hello World  Superuser !";
    }

    public function test2()
    {
        return "Hello World  Admin !";
    }
}
