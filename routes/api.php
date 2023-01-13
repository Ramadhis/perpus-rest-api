<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/login', [AuthController::class,'login']);
Route::post('/register', [AuthController::class,'register']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get('/get-token', [AuthController::class, 'get_token']);
});

Route::group(['middleware' => 'auth:sanctum','prefix' => 'book'], function(){
    Route::get('/', [BukuController::class, 'index']);
    Route::get('/find-book/{id}', [BukuController::class, 'find_book']);
    Route::post('/create', [BukuController::class, 'create']);
    Route::put('/update', [BukuController::class, 'update']);
    Route::delete('/delete/{id}', [BukuController::class, 'delete_by_id']);
});

// Route::get('/book', [BookController::class, 'index'])->middleware('auth:sanctum');