<?php

namespace app\Controllers;

use app\Models\Reader;
use core\Src\Request;
use core\Src\Session;
use core\Src\View;


class ReadersController
{
    public function profile(Request $request): string
    {
        // TODO: Where should a validation be?
        $user = app()->auth::user();
        $reader = Reader::find_by_user_id($user->get_id());
        $books = $reader->get_ordered_books();

        if ($request->method === 'POST') {
            // TODO: Perhaps there is another method to identify form
            if ($request->get('activate')) {
                $reader->activate_reader(
                    $request->address,
                    $request->phone,
                );
                $url = $request->get('refer_to') ?? '/profile';
                app()->route->redirect($url);
            }
        }
        return new View('readers/profile', [
            'reader' => $reader,
            'books' => $books,
            'user' => $user
        ]);
    }
}