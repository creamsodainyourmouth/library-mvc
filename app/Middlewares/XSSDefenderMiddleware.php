<?php

namespace app\Middlewares;

use core\Src\Request;

class XSSDefenderMiddleware
{
    // TODO: Create RequestHelper::class with func
    public function handle(Request $request): Request
    {
        $special_chars = function ($value, $key) use ($request) {
            $request->set($key, is_string($value) ? htmlspecialchars($value) : $value);
        };
        // request is not local variable?
        // $all = &$request->all();

        $all = $request->all();
        array_walk($all, $special_chars);
        return $request;
    }
}