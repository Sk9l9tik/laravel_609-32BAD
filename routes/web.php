<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return view('hello', ['title' => 'Howdy, World!']);
});

route::get('/paste', [pastecontroller::class, 'index']);
route::get('/paste/create', [pastecontroller::class, 'create']);
route::get('/paste/{id}', [pastecontroller::class, 'show']);
Route::post('/paste/store', [pastecontroller::class, 'store']);
Route::get('/paste/destroy/{id}', [PasteController::class, 'destroy']);
Route::get('/paste/edit/{id}', [PasteController::class, 'edit']);
Route::post('/paste/update/{id}', [PasteController::class, 'update']);

route::get('/comment', [commentcontroller::class, 'index']);

route::get('/user', [usercontroller::class, 'index']);
route::get('/user/{id}', [usercontroller::class, 'show']);
