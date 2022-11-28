<?php
use core\Src\Route;
use app\Controllers\SiteController;
use app\Controllers\AdminController;
use app\Controllers\ReadersController;
use app\Controllers\BooksController;


Route::add(['GET'], '/', [SiteController::class, 'index']);

Route::add(['GET'], '/admin', [AdminController::class, 'index'])
    ->middleware('auth', 'role');

Route::add(['GET'], '/admin/books', [AdminController::class, 'books_list'])
    ->middleware('auth', 'role');
Route::add(['GET'], '/admin/readers', [AdminController::class, 'readers_list'])
    ->middleware('auth', 'role');
Route::add(['GET'], '/admin/book', [AdminController::class, 'detail_book'])
    ->middleware('auth', 'role');
Route::add(['GET', 'POST'], '/admin/reader', [AdminController::class, 'detail_reader'])
    ->middleware('auth', 'role');
Route::add(['GET', 'POST'], '/admin/reader/edit-orders', [AdminController::class, 'edit_orders_of_reader'])
    ->middleware('auth', 'role');



Route::add(['GET', 'POST'], '/profile', [ReadersController::class, 'profile'])
    ->middleware('auth');

Route::add(['GET'], '/books', [BooksController::class, 'list']);
Route::add(['GET', 'POST'], '/book/order', [BooksController::class, 'make_order'])
    ->middleware('auth', 'activation');
Route::add(['GET'], '/book', [BooksController::class, 'detail']);

Route::add(['GET'], '/about', [SiteController::class, 'about']);
Route::add(['GET'], '/events', [SiteController::class, 'events']);
Route::add(['GET'], '/editions', [SiteController::class, 'editions']);
Route::add(['GET'], '/readers', [SiteController::class, 'readers']);

Route::add(['GET', 'POST'], '/signup', [SiteController::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [SiteController::class, 'login']);
Route::add('GET', '/logout', [SiteController::class, 'logout']);
