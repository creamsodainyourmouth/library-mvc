<?php

//use core\Src\Auth\Auth;

return [
    'app_prefix' => '',
// Класс аутентификации
    'auth' => \core\Src\Auth\Auth::class,
// Клас пользователя
    'identity'=> \app\Models\User::class,
    'route_middleware' => [
        'auth' => \app\Middlewares\AuthMiddleware::class,
        'role' => \app\Middlewares\RoleMiddleware::class,
        'activation' => \app\Middlewares\ActivationReaderMiddleware::class,
    ],
    'route_app_middleware' => [
        'trim' => \app\Middlewares\TrimMiddleware::class,
        'xss_defender' => \app\Middlewares\XSSDefenderMiddleware::class,
    ],
    'validators' => [
        'required' => \app\Validators\RequireValidator::class,
        'unique' => \app\Validators\UniqueValidator::class,
        'password' => \app\Validators\PasswordValidator::class,
    ]
];
