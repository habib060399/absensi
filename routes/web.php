<?php

use Illuminate\Support\Facades\Route;
use App\Events\SendPresence;
use App\Models\User;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ControllerView;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserViewController;
use App\Http\Controllers\AdminViewController;

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

Route::get('/',[AuthController::class, 'login'])->name('login');
Route::post('/auth-user',[AuthController::class, 'authUser']);
Route::get('/logout',[AuthController::class, 'logout']);

Route::get('/live-absen', [UserViewController::class, 'liveAbsen']);

Route::prefix('flockbase')->middleware(['auth', 'can:isAdmin'])->group(function(){
    Route::get('/home', [AdminViewController::class, 'home'])->name('homeAdmin');
    // Route::get('/absen', [ControllerView::class, 'dataAbsen'])->name('absen');
    Route::get('/sekolah', [AdminViewController::class, 'sekolah'])->name('sekolah');
    Route::get('/sekolah/tambah', [ControllerView::class, 'addSekolah'])->name('sekolah-add');
    Route::post('/tambah-sekolah', [AdminController::class, 'registerSekolah'])->name('add_sekolah');
    Route::get('/mesin', [AdminViewController::class, 'mesin'])->name('mesin');
    Route::post('/tambah-mesin', [AdminController::class, 'registerMesin'])->name('add_mesin');
});

Route::prefix('user')->middleware(['auth', 'can:isSekolah'])->group(function(){
    Route::get('/live-absen', [UserViewController::class, 'liveAbsen'])->name('live_absen');
    Route::get('/jurusan', [UserViewController::class, 'jurusan'])->name('jurusan');
    Route::post('/tambah-jurusan', [UserController::class, 'registerJurusan'])->name('add_jurusan');
    Route::get('/jurusan/hapus/{id}', [UserController::class, 'hapusJurusan'])->name('hapus_jurusan');
    Route::get('/jurusan/{id}', [UserViewController::class, 'editJurusan'])->name('edit_jurusan');
    Route::post('/jurusan/edit', [UserController::class, 'editJurusan'])->name('edit_jurusan1');
    Route::get('/kelas', [UserViewController::class, 'kelas'])->name('kelas');
    Route::get('/kelas/hapus/{id}', [UserController::class, 'hapusKelas'])->name('hapus_kelas');
    Route::get('/kelas/{id}', [UserViewController::class, 'editKelas'])->name('editKelas');
    Route::post('/tambah-kelas', [UserController::class, 'registerKelas'])->name('add_kelas');
    Route::get('/siswa', [UserViewController::class, 'siswa'])->name('siswa');
    Route::get('/siswa/edit/{id}', [UserViewController::class, 'editSiswa'])->name('editSiswa');
    Route::post('/siswa/edit/send/{id}', [UserController::class, 'editSiswa'])->name('edit_siswa');
    Route::get('/siswa/tambah', [UserViewController::class, 'addSiswa'])->name('siswa_add');
    Route::post('/siswa/tambah/tambah-siswa', [UserController::class, 'registerSiswa'])->name('add_siswa');
    Route::post('/get-kelas', [UserController::class, 'getKelas'])->name('getkls');
    Route::get('/pesan', [UserViewController::class, 'pesan'])->name('pesan');
    Route::post('/pesan/edit', [UserController::class, 'editPesan'])->name('edit_bc');
    Route::get('/absensi', [UserViewController::class, 'absen'])->name('absen');
    Route::post('/absen/get-absen', [UserController::class, 'getAbsen'])->name('getAbsen');
    Route::post('/broadcast/get-siswa', [UserController::class, 'getSiswa'])->name('getSiswa');

    Route::get('/siswa/hapus/{model}/{id}', [UserController::class, 'hapus'])->name('hapus');
    Route::get('/absen/hapus/{id}/{tanggal}', [UserController::class, 'delAbsen'])->name('hapus_absen');
    Route::get('/profile', [UserViewController::class, 'profile'])->name('profile');
    Route::get('/broadcast', [UserViewController::class, 'broadcast'])->name('bc');
    Route::post('/broadcast/send', [UserController::class, 'sendBc'])->name('send_bc');
    Route::get('/home', [UserViewController::class, 'home'])->name('homeSekolah');
    Route::post('/absen/insert', [UserController::class, 'insertAbsenManual'])->name('input_absen');
    Route::get('/absen/edit', [UserController::class, 'editAbsen'])->name('edit_absen');
    Route::post('/absen/edit/simpan', [UserController::class, 'insertEditAbsen'])->name('simpan_edit_absen');
    Route::get('/siswa/download-template', [UserController::class, 'exportTemplateSiswa'])->name('template_siswa');
    Route::post('/siswa/import', [UserController::class, 'importSiswa'])->name('import_siswa');

    Route::get('/rekap', [UserViewController::class, 'rekapAbsen'])->name('rekap');
    Route::post('/rekap/download', [UserController::class, 'rekapAbsen'])->name('download_rekap');
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