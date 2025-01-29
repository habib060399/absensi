<?php

use Illuminate\Support\Facades\Route;
use App\Events\SendPresence;
use App\Models\User;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\ControllerView;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\UserViewController;
use App\Http\Controllers\AdminViewController;
use App\Http\Controllers\Admin\SekolahController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\WhatsappController;
use App\Http\Controllers\SekolahController as UserSekolahController;


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
    Route::get('/sekolah', [SekolahController::class, 'index'])->name('admin_sekolah');
    Route::get('/sekolah/wizard', [SekolahController::class, 'wizard'])->name('wizard');
    Route::get('/sekolah/tambah', [ControllerView::class, 'addSekolah'])->name('sekolah-add');
    Route::post('/tambah-sekolah', [SekolahController::class, 'store'])->name('add_sekolah');
//    Route::post('/tambah-sekolah', [AdminController::class, 'registerSekolah'])->name('add_sekolah');
    Route::get('/mesin', [AdminViewController::class, 'mesin'])->name('mesin');
    Route::post('/tambah-mesin', [AdminController::class, 'registerMesin'])->name('add_mesin');
    Route::get('/sekolah/hapus/{id}', [SekolahController::class, 'delete'])->name('sekolah-hapus');
    Route::get('/sekolah/{id}/edit', [SekolahController::class, 'edit'])->name('sekolah-edit');
    Route::post('/sekolah/edit/{id}/simpan', [SekolahController::class, 'update'])->name('simpan-edit-sekolah');
    Route::get('/sekolah/paket/{id}', [AdminViewController::class, 'paket'])->name('paket');
    Route::get('/sekolah/paket/{id}/{paket}', [AdminController::class, 'registerPaket'])->name('paket-add');
    Route::get('/sekolah/paket2/{id}', [\App\Helpers\Helper::class, 'getPaket'])->name('paket-add2');
    Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice');
    Route::get('/invoice/{id}', [InvoiceController::class, 'showInvoice'])->name('invoice2');
    Route::get('/sekolah/invoice/download/{id}', [InvoiceController::class, 'generateInvoicePDF'])->name('invoice-download');
});

Route::prefix('user')->middleware(['auth', 'check:isSekolah,isKelas', 'check.active'])->group(function(){
    Route::get('/live-absen', [UserViewController::class, 'liveAbsen'])->name('live_absen');
    Route::get('/jurusan', [UserViewController::class, 'jurusan'])->name('jurusan');
    Route::post('/tambah-jurusan', [UserController::class, 'registerJurusan'])->name('add_jurusan');
    Route::get('/jurusan/hapus/{id}', [UserController::class, 'hapusJurusan'])->name('hapus_jurusan');
    Route::get('/jurusan/{id}', [UserViewController::class, 'editJurusan'])->name('edit_jurusan');
    Route::post('/jurusan/edit', [UserController::class, 'editJurusan'])->name('edit_jurusan1');
    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas');
    Route::get('/kelas/hapus/{id}', [UserController::class, 'hapusKelas'])->name('hapus_kelas');
    Route::get('/kelas/{id}/edit', [KelasController::class, 'edit'])->name('editKelas');
    Route::post('/kelas/{id}/edit/update', [KelasController::class, 'update'])->name('e.kelas');
    Route::post('/tambah-kelas', [KelasController::class, 'store'])->name('add_kelas');
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa');
    Route::post('/siswa/get-siswa', [SiswaController::class, 'getSiswaByDate'])->name('get_siswa_by_tgl');
    Route::get('/siswa/naik-kelas', [UserViewController::class, 'siswaNaik'])->name('siswa_naik_kelas');
    Route::post('/tambah-jabatan', [GuruController::class, 'insertJabatan'])->name('add_jabatan');
    Route::get('/guru', [GuruController::class, 'index'])->name('guru');
    Route::get('/guru/edit/{id}', [GuruController::class, 'showEditGuru'])->name('sh_edit_guru');
    Route::post('/guru/edit/send{id}', [GuruController::class, 'editGuru'])->name('edit_guru');
    Route::get('/guru/tambah', [GuruController::class, 'showInsertGuru'])->name('add_guru');
    Route::post('/guru/tambah/tambah-guru', [GuruController::class, 'insertGuru'])->name('guru_tambah');
    Route::get('/guru/hapus/{id}', [GuruController::class, 'deleteGuru'])->name('hapus_guru');
    Route::get('/siswa/{id}/edit', [SiswaController::class, 'edit'])->name('editSiswa');
    Route::post('/siswa/edit/send/{id}', [SiswaController::class, 'update'])->name('edit_siswa');
    Route::get('/siswa/tambah', [UserViewController::class, 'addSiswa'])->name('siswa_add');
//    Route::post('/siswa/tambah/tambah-siswa', [UserController::class, 'registerSiswa'])->name('add_siswa');
    Route::post('/siswa/tambah/tambah-siswa', [SiswaController::class, 'store'])->name('add_siswa');
    Route::post('/get-kelas', [UserController::class, 'getKelas'])->name('getkls');
    Route::get('/get-kelas-1', [KelasController::class, 'getAllKelas'])->name('get_all_kelas');
    Route::post('/get-kelas/id', [KelasController::class, 'getKelasById'])->name('get_kelas_id');
    Route::post('/get-kelas-2', [GuruController::class, 'getKelas'])->name('getkls2');
    Route::get('/pesan', [UserViewController::class, 'pesan'])->name('pesan');
    Route::post('/pesan/edit', [UserController::class, 'editPesan'])->name('edit_bc');
    Route::get('/absensi', [UserViewController::class, 'absen'])->name('absen');
    Route::post('/absen/get-absen', [AbsenController::class, 'getAllAbsen'])->name('getAbsen');
    // Route::post('/broadcast/get-siswa', [UserController::class, 'getSiswa'])->name('getSiswa');

    Route::get('/siswa/hapus/{id}', [UserController::class, 'hapusSiswa'])->name('hapus');
    Route::get('/absen/hapus/{id}/{tanggal}', [UserController::class, 'delAbsen'])->name('hapus_absen');
    Route::get('/profile', [UserViewController::class, 'profile'])->name('profile');
    Route::get('/profile1', [UserViewController::class, 'profile1'])->name('profile1');
    Route::get('/broadcast', [UserViewController::class, 'broadcast'])->name('bc');
    Route::post('/broadcast/send', [UserController::class, 'sendBc'])->name('send_bc');
    Route::get('/home', [UserViewController::class, 'home'])->name('homeSekolah');
    Route::post('/absen/insert', [AbsenController::class, 'store'])->name('input_absen');
    Route::get('/absen/edit', [UserController::class, 'editAbsen'])->name('edit_absen');
    Route::post('/absen/edit/simpan', [UserController::class, 'insertEditAbsen'])->name('simpan_edit_absen');
    Route::post('/siswa/download-template', [UserController::class, 'exportTemplateSiswa'])->name('template_siswa');
    Route::post('/siswa/import', [UserController::class, 'importSiswa'])->name('import_siswa');

    Route::get('/rekap', [UserViewController::class, 'rekapAbsen'])->name('rekap');
    Route::post('/rekap/download', [UserController::class, 'rekapAbsen'])->name('download_rekap');
    Route::post('/profile/tambah', [UserController::class, 'registerUser'])->name('tambah_user');
    Route::get('/whatssap', [WhatsappController::class, 'index'])->name('wa');
    Route::get('/group', [WhatsappController::class, 'groupIndex'])->name('wa_group');
    Route::post('/whatssap/hapus', [WhatsappController::class, 'destroy'])->name('delete_message');
    Route::post('/whatssap/tambah', [UserController::class, 'registerWa'])->name('wa_tambah');
    Route::get('/whatssap/update', [UserController::class, 'updateGroupWa'])->name('wa_update');
    Route::post('/absensi/siswa-option', [AbsenController::class, 'siswaGetOption'])->name('option_siswa');

    Route::get('sekolah', [UserSekolahController::class, 'index'])->name('sekolah');
});
Route::post('user/broadcast/get-siswa', [SiswaController::class, 'findContact'])->name('getSiswa');
// Route::post('user/siswa/get-siswa', [SiswaController::class, 'getSiswaByDate'])->name('get_siswa_by_tgl');
Route::match(['get', 'post'],'/webhook', function () {
//    return include(app_path('Webhook/mywebhook.php'));
    return include(app_path('WebhookWA/webhookWa.php'));
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
