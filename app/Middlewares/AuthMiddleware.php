<?php

namespace app\Middlewares;

use core\Src\Auth\Auth;
use core\Src\Request;
use core\Src\Session;

class AuthMiddleware
{
    public function handle(Request $request)
    {
        if (!Auth::check()) {
            app()->route->redirect("/login?refer_to=$request->refer_to");

        }

    }
}