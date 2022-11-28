<?php

namespace app\Middlewares;

use app\Models\Reader;
use core\Src\Request;
use core\Src\Session;

class ActivationReaderMiddleware
{
    public function handle(Request $request)
    {
        $user_id = Session::get('id');
        $reader = Reader::find_by_user_id($user_id);
        if (! $reader->is_activated()) {
            app()->route->redirect("/profile?refer_to=$request->refer_to");
        }

    }
}