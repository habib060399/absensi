<?php

use Illuminate\Support\Facades\Route;
use App\Events\SendPresence;
use App\Models\User;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ControllerView;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserViewController;

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

Route::get('/',[ControllerView::class, 'login'])->name('login');
Route::post('/auth-user',[AuthController::class, 'authUser']);
Route::get('/logout',[AuthController::class, 'logout']);

Route::get('/live-absen', function () {
    return view('absensi_live');
});

Route::prefix('flockbase')->middleware(['auth'])->group(function(){
    Route::get('/home', [ControllerView::class, 'home'])->name('home');
    Route::get('/absen', [ControllerView::class, 'dataAbsen'])->name('absen');
    Route::get('/sekolah', [ControllerView::class, 'dataSekolah'])->name('sekolah');
    Route::get('/sekolah/tambah', [ControllerView::class, 'addSekolah'])->name('sekolah-add');
    Route::post('/tambah-sekolah', [AdminController::class, 'registerSekolah'])->name('add_sekolah');
    Route::get('/mesin', [ControllerView::class, 'dataMesin'])->name('mesin');
    Route::post('/tambah-mesin', [AdminController::class, 'registerMesin'])->name('add_mesin');
});

Route::prefix('user')->middleware(['auth'])->group(function(){
    Route::get('/jurusan', [UserViewController::class, 'jurusan'])->name('jurusan');
    Route::post('/tambah-jurusan', [UserController::class, 'registerJurusan'])->name('add_jurusan');
    Route::get('/jurusan/hapus/{id}', [UserController::class, 'hapusJurusan'])->name('hapus_jurusan');
    Route::get('/kelas', [UserViewController::class, 'kelas'])->name('kelas');
    Route::get('/kelas/hapus/{id}', [UserController::class, 'hapusKelas'])->name('hapus_kelas');
    Route::get('/kelas/{id}', [UserViewController::class, 'editKelas'])->name('editKelas');
    Route::post('/tambah-kelas', [UserController::class, 'registerKelas'])->name('add_kelas');
    Route::get('/siswa', [UserViewController::class, 'siswa'])->name('siswa');
    Route::get('/siswa/tambah/{id}', [UserViewController::class, 'editSiswa'])->name('editSiswa');
    Route::get('/siswa/tambah', [UserViewController::class, 'addSiswa'])->name('siswa_add');
    Route::post('/siswa/tambah/tambah-siswa', [UserController::class, 'registerSiswa'])->name('add_siswa');
    Route::post('/get-kelas', [UserController::class, 'getKelas'])->name('getkls');

    Route::get('/siswa/hapus/{model}/{id}', [UserController::class, 'hapus'])->name('hapus');
});

Route::get('broadcast', function() {
    $user = User::find(2);
    // dd($user);
    broadcast(new SendPresence());
    // return 'Event Success sent';
});

// Route::get('/register-device', [AdminController::class, 'registerView']);
// Route::post('/register-device/create', [AdminController::class, 'createDevice'])->name('create_device');
// Route::get('/login_device', [AdminController::class, 'loginDeviceView']);
// Route::post('/login_device/create', [AdminController::class, 'loginDevice'])->name('login_device');