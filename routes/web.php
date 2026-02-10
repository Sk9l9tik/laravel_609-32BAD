<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasteController;
use App\Http\Controllers\PasteControllerApi;
use App\Http\Controllers\CommentControllerApi;
use App\Http\Controllers\UserControllerApi;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => view('welcome'))->name('home');
Route::get('/hello', fn () => view('hello', ['title' => 'Howdy, World!']))->name('hello');

/*
 | Paste CRUD
*/
Route::get('/paste', [PasteController::class, 'index'])->name('paste.index');
Route::get('/paste/create', [PasteController::class, 'create'])->middleware('auth')->name('paste.create');
Route::post('/paste/store', [PasteController::class, 'store'])->middleware('auth')->name('paste.store');
Route::get('/paste/{id}', [PasteController::class, 'show'])->name('paste.show');
Route::get('/paste/edit/{id}', [PasteController::class, 'edit'])->middleware('auth')->name('paste.edit');
Route::post('/paste/update/{id}', [PasteController::class, 'update'])->middleware('auth')->name('paste.update');
Route::delete('/paste/destroy/{id}', [PasteController::class, 'destroy'])->middleware('auth')->name('paste.destroy');

/*
 | Auth
*/
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/auth', [LoginController::class, 'auth'])->name('auth');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
 | Api Controllers
 */
Route::get("/pastes", [PasteControllerApi::class, "index"]);
Route::get("/pastes/{id}", [PasteControllerApi::class, "show"]);

Route::get("/comments", [CommentControllerApi::class, "index"]);
Route::get("/comments/{id}", [CommentControllerApi::class, "show"]);

Route::get("/users", [UserControllerApi::class, "index"]);
Route::get("/users/{id}", [UserControllerApi::class, "show"]);
