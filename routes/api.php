<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasteControllerApi;
use App\Http\Controllers\CommentControllerApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserControllerApi;

/*
 | Api Controllers
 */
Route::get("/pastes", [PasteControllerApi::class, "index"]);
Route::get("/pastes/{id}", [PasteControllerApi::class, "show"]);

Route::get("/comments", [CommentControllerApi::class, "index"]);
Route::get("/comments/{id}", [CommentControllerApi::class, "show"]);

Route::get("/users", [UserControllerApi::class, "index"]);
Route::get("/users/{id}", [UserControllerApi::class, "show"]);

Route::post("/login", [AuthController::class, 'login']);
