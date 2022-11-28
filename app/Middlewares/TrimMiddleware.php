<?php

namespace app\Middlewares;

use core\Src\Request;

// TODO: Speed test

class TrimMiddleware
{
    public function handle(Request $request): Request
    {
        $trim_if_string = function ($value, $key) use ($request) {
            $request->set($key, is_string($value) ? trim($value) : $value);
        };
        // request is not local variable?
        // $all = &$request->all();

         $all = $request->all();
        array_walk($all, $trim_if_string);
        return $request;
    }
}


