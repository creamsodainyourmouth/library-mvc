<?php

namespace app\Controllers;

use app\Models\Book;
use app\Models\BookInstance;
use app\Models\OrderedBook;
use app\Models\Post;
use app\Models\Reader;
use core\Src\Session;
use core\Src\View;

use core\Src\Auth\Auth;
use core\Src\Request;

use Illuminate\Database\Capsule\Manager as DB;

class BooksController
{
    public function detail(Request $request): string
    {
        $book_id = $request->id;
        $book = BookInstance::get_detail_book($book_id);
        return new View('books/detail', [
           'book' => $book
        ]);
    }

    public function list(Request $request): string
    {
        $books =  BookInstance::get_books_list();
        return new View('books/list', ['books' => $books]);
    }

    public function make_order(Request $request): string
    {
        $book_id = $request->get('id');
        $book = BookInstance::get_detail_book($book_id);
        $user_id = Session::get('id');
        $reader_lib_card = Reader::find_by_user_id($user_id)->get_lib_card();

        pprint($reader_lib_card);

        if ($request->method === 'POST') {
            pprint($request->all());
            OrderedBook::create_order(
                $request->id,
                $request->reader_lib_card,
                $request->issue_date,
                $request->delivery_date,
            );
            app()->route->redirect('/profile');
        }
        return new View('books/make_order', [
            'reader_lib_card' => $reader_lib_card,
            'book' => $book
        ]);
    }
}