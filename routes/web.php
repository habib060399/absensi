<?php

use Illuminate\Support\Facades\Route;
use App\Events\SendPresence;
use App\Models\User;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('broadcast', function() {
    $user = User::find(2);
    // dd($user);
    broadcast(new SendPresence());
    // return 'Event Success sent';
});

Route::get('/register-device', [AdminController::class, 'registerView']);
Route::post('/register-device/create', [AdminController::class, 'createDevice'])->name('create_device');