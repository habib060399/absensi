<?php

use App\Http\Controllers\API\RfidController;
use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\API\CurlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('/check-device', [RfidController::class, 'checkIdDevice']);
Route::post('/scan-device', [RfidController::class, 'scan'])->name('scan');
// Route::post('/login', [RfidController::class, 'login']);
// Route::get('/absensi', [RfidController::class, 'index']);
Route::post('/absensi', [RfidController::class, 'store']);
Route::get('search/name', [ApiController::class, 'searchNamaSiswa'])->name('search_nama_siswa');
Route::post('wa/group', [CurlController::class, 'getGroupWa']);
Route::post('wa/group/update', [CurlController::class, 'updateGroupWa']);
Route::middleware(['auth:sanctum'])->group(function(){
});
