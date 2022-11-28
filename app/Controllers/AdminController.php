<?php

namespace app\Controllers;

use app\Models\BookInstance;
use app\Models\OrderedBook;
use core\Src\Session;
use core\Src\Validators\Validator;
use core\Src\View;
use core\Src\Auth\Auth;
use core\Src\Request;

use Illuminate\Database\Capsule\Manager as DB;

use app\Models\Reader;

class AdminController
{
    public function index(Request $request):string
    {
        return new View('admin/index');
    }

     public function books_list(Request $request): string
    {
        $books = BookInstance::get_admin_books_list();

        return new View('admin/books_list', [
            'books' => $books
        ]);
    }

    public function detail_book(Request $request): string
    {
        $book_instance_id = $request->id;
        $detail_book = BookInstance::get_admin_detail_book($book_instance_id);

        return new View('admin/detail_book', [
            'book' => $detail_book['book'],
            'readers' => $detail_book['readers'],
            'statuses' => $detail_book['statuses'],
            'statuses_labels' => OrderedBook::get_statuses_labels(),
        ]);
    }

    public function readers_list(): string
    {

        $readers = Reader::get_admin_readers_list();
        return new View('admin/readers_list', ['readers' => $readers]);
    }

    public function detail_reader(Request $request): string
    {

        $reader_lib_card = $request->get('lib_card');
        $detail_reader = Reader::get_admin_detail_reader($reader_lib_card);

        return new View('admin/detail_reader', [
            'reader' => $detail_reader['reader'],
            'statuses' => $detail_reader['statuses'],
            'books' => $detail_reader['ordered_books'],
            'statuses_labels' => OrderedBook::get_statuses_labels()
        ]);
    }

    public function edit_orders_of_reader(Request $request): string
    {
        $editable_orders_ids = $request->get('editable_orders');
        if ($request->get('save') !== null) {
            $new_columns = [
                'new_delivery_dates' => 'delivery_date',
                'new_statuses' => 'status'
            ];
            foreach ($new_columns as $columns_values => $column) {
                foreach ($request->$columns_values as $order_id => $new_value) {
                    DB::table('ordered_books')
                        ->where('ordered_books.id', $order_id)
                        ->update([$column => $new_value]);
                }
            }
            app()->route->redirect("/admin/reader?lib_card=$request->lib_card");
        }

        $reader_lib_card = $request->get('lib_card');
        $reader = Reader::get_admin_detail_reader_only($reader_lib_card);
        $reader_stats = Reader::get_orders_statuses_of_reader($reader_lib_card);
        $editable_orders = Reader::get_editable_ordered_books_of_reader($reader_lib_card, $editable_orders_ids);
        $statuses_options = OrderedBook::get_statuses_labels();
        return new View('admin/edit_orders_of_reader', [
            'books' => $editable_orders,
            'reader' => $reader,
            'statuses_options' => $statuses_options,
            'stats' => $reader_stats
        ]);

    }
}