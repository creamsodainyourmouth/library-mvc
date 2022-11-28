<?php

namespace app\Controllers;

use app\Models\Reader;
use core\Src\Session;
use core\Src\Validators\Validator;
use core\Src\View;
use core\Src\Auth\Auth;
use core\Src\Request;

use Illuminate\Database\Capsule\Manager as DB;

use app\Models\Post;
use app\Models\User;


class SiteController
{
    public function index(Request $request): void
    {
        app()->route->redirect('/books');
    }

    public function signup(Request $request): string
    {
        if ($request->method === 'POST') {

            // TODO: Move to Model
            $validator = new Validator($request->all(), [
                'name' => ['required'],
                'surname' => ['required'],
//                'address' => ['required'],
                'email' => ['required', 'unique:users,email'],

                // TODO: Соответствующее сообщение выводится только для последнего валидатора:
                // поле пароля пусто, однако выводится специфическое сообщение
                // валидатора password для данного поля - сколько несоответствий столько и сообщений.
                'password' => ['required', 'password']
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально',
                'password' => 'Допустимая длина пароля 6-32 символа',
            ]);

            if ($validator->fails()) {
                return new View(
                    'site/signup',
                    ['message' => json_encode($validator->errors(),JSON_UNESCAPED_UNICODE)]
//                    ['message' => $validator->errors()]
                );
            }
            $new_user = User::create($request->all());

            if ($new_user) {
                app()->route->redirect('/login');
            }
        }
        return new View('site/signup');
    }

    public function login(Request $request): string
    {
        if ($request->method === 'GET') {
            return new View('site/login');
        }
        if (Auth::attempt($request->all())) {
            $url = $request->get('refer_to') ?? '/profile';
            app()->route->redirect($url);

        }
        return new View('site/login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/login');
    }

    public function hello(Request $request): string
    {
        echo '<br> hello!)';
        $posts = Post::all();
        return new View('site/posts', ['posts'=> $posts]);
    }

    public function about(Request $request): string
    {
        return new View('site/about');
    }

    public function events(Request $request): string
    {
        return new View('site/events');
    }

    public function readers(Request $request): string
    {
        return new View('site/readers');
    }

    public function editions(Request $request): string
    {
        return new View('site/editions');
    }

}