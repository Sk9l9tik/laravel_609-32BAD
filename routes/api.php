<?php

use app\Http\Controllers\PasteControllerApi;

use Illuminate\Support\Facades\Route;

Route::get("/pastes", [PasteControllerApi::class, "index"]);
Route::get("/pastes/{id}", [PasteControllerApi::class, "show"]);
