<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\DendaController;


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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/get-token', [AuthController::class, 'get_token']);
});

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'buku'], function () {
    Route::get('/', [BukuController::class, 'index']);
    Route::get('/find-book/{id}', [BukuController::class, 'find_book']);
    Route::post('/create', [BukuController::class, 'create']);
    Route::put('/update/{id}', [BukuController::class, 'update']);
    Route::delete('/delete/{id}', [BukuController::class, 'delete_by_id']);
});
Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'member'], function () {
    Route::get('/', [MemberController::class, 'index']);
    Route::get('/find-member/{id}', [MemberController::class, 'find_member']);
    Route::post('/create', [MemberController::class, 'create']);
    Route::put('/update/{id}', [MemberController::class, 'update']);
    Route::delete('/delete/{id}', [MemberController::class, 'delete_by_id']);
});

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'peminjaman'], function () {
    Route::get('/', [PeminjamanController::class, 'index']);
    Route::get('/find-peminjam/{id_member}', [PeminjamanController::class, 'find_peminjam_byMemberId']);
    Route::post('/peminjaman', [PeminjamanController::class, 'peminjaman']);
    Route::put('/pengembalian/{id}', [PeminjamanController::class, 'pengembalian']);
    Route::put('/update/{id}', [PeminjamanController::class, 'update']);
    Route::delete('/delete/{id}', [PeminjamanController::class, 'delete_by_id']);
});

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'denda'], function () {
    Route::get('/', [DendaController::class, 'index']);
    Route::post('/create', [DendaController::class, 'create']);
    Route::put('/update/{id}', [PeminjamanController::class, 'update']);
    Route::delete('/delete/{id}', [DendaController::class, 'delete_by_id']);
    Route::get('/find-denda/{id_member}', [DendaController::class, 'find_by_memberId']);
});

// Route::get('/book', [BookController::class, 'index'])->middleware('auth:sanctum');