<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GuruController;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Api\KelasController;

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

Route::post('/register', App\Http\Controllers\Api\RegisterController::class)->name('register');
Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:api']], function () {

    Route::get('guru', [GuruController::class, 'index']);
    // GURU -------------------
// ====> TAMBAH DATA
    Route::post('guru', [GuruController::class, 'store']);
// MENAMPILKAN DATA
    Route::get('guru', [GuruController::class, 'index']);
    Route::get('guru/{id}', [GuruController::class, 'show']);
// UPDATE DATA
    Route::put('guru/{id}', [GuruController::class, 'update']);
// PROSES DELETE
    Route::delete('guru/{id}', [GuruController::class, 'delete']);

// SISWA -------------------
// ====> TAMBAH DATA
    Route::post('siswa', [SiswaController::class, 'store']);
// MENAMPILKAN DATA
    Route::get('siswa', [SiswaController::class, 'index']);
    Route::get('siswa/{id}', [SiswaController::class, 'show']);
// UPDATE DATA
    Route::put('siswa/{id}', [SiswaController::class, 'update']);
// PROSES DELETE
    Route::delete('siswa/{id}', [SiswaController::class, 'delete']);

// KELAS -------------------
// ====> TAMBAH DATA
    Route::post('kelas', [KelasController::class, 'store']);
// MENAMPILKAN DATA
    Route::get('kelas', [KelasController::class, 'index']);
    Route::get('kelas/{id}', [KelasController::class, 'show']);
// UPDATE DATA
    Route::put('kelas/{id}', [KelasController::class, 'update']);
// PROSES DELETE
    Route::delete('kelas/{id}', [KelasController::class, 'delete']);

    Route::post('/logout', App\Http\Controllers\Api\LogoutController::class)->name('logout');
});
