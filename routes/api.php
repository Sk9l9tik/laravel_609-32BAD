<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasteControllerApi;
use App\Http\Controllers\CommentControllerApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserControllerApi;
use App\Models\Paste;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Laravel\Sanctum\HasApiTokens;  // ← ADD THIS

/*
 | Api Controllers
 */
Route::get("/pastes", [PasteControllerApi::class, "index"]);
Route::get("/pastes/{id}", [PasteControllerApi::class, "show"]);
Route::post('/pastes/create', [PasteControllerApi::class, 'store']);

Route::get("/comments", [CommentControllerApi::class, "index"]);
Route::get('/pastes/{id}/comments', [CommentControllerApi::class, 'index']);
Route::get('/pastes/{id}/comments/total', [CommentControllerApi::class, 'total']);
Route::post('/pastes/{id}/comments', [CommentControllerApi::class, 'store'])->middleware('auth:sanctum');

Route::get("/users/{id}", [UserControllerApi::class, "show"]);

Route::post("/login", [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/users',[UserControllerApi::class, 'index']);


Route::group(['middleware'=>['auth:sanctum']], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/user/pastes', [PasteControllerApi::class, "user_pastes"]);
    Route::get('/user/total-pastes', [PasteControllerApi::class, "total_user_pastes"]);

    Route::get("/pastes", [PasteControllerApi::class, "index"]);

    Route::get('/logout', [AuthController::class, 'logout']);
});

// Route::post('/pastes/create', [PasteControllerApi::class, 'store']);
