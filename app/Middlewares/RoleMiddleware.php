<?php

namespace app\Middlewares;

use core\Src\Auth\Auth;
use core\Src\Request;

class RoleMiddleware
{
    public function handle(Request $request)
    {
        if ( !Auth::user()->isAdmin()) {
            app()->route->redirect('/profile');
        }

    }

}