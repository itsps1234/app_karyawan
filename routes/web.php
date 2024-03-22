<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\IdCardController;
use App\Http\Controllers\KPIController;
use App\Http\Controllers\SlipController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\KIBController;
use App\Http\Controllers\TIBController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\LemburController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\jabatanController;
use App\Http\Controllers\karyawanController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\RekapDataController;
use App\Http\Controllers\HomeUserController;
use App\Http\Controllers\HistoryUserController;
use App\Http\Controllers\ProfileUserController;
use App\Http\Controllers\AbsenUserController;
use App\Http\Controllers\IzinUserController;
use Carbon\Carbon;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware('auth','log.activity')->group(function () {
    Route::post('/logout', [authController::class, 'logout']);
    Route::put('/karyawan/proses-edit-shift/{id}', [karyawanController::class, 'prosesEditShift']);
    Route::get('/id-card', [IdCardController::class, 'index']);
    Route::get('/kpi', [KPIController::class, 'index']);
    Route::get('/my-slip', [SlipController::class, 'index']);
    Route::get('/pengajuan', [PengajuanController::class, 'index']);
    Route::get('/kib', [KIBController::class, 'index']);
    Route::get('/tib', [TIBController::class, 'index']);
    Route::get('/my-division', [DivisionController::class, 'index']);
    Route::get('/my-location', [AbsenController::class, 'myLocation']);
    Route::get('/absen', [AbsenController::class, 'index']);

    Route::get('/home', [HomeUserController::class, 'index']);
    Route::put('/home/absen/masuk/{id}', [HomeUserController::class, 'absenMasuk']);
    Route::get('/home/absen', [HomeUserController::class, 'HomeAbsen']);
    Route::get('/home/maps/{lat}/{long}', [HomeUserController::class, 'maps']);
    Route::get('/home/my-absen', [HomeUserController::class, 'myAbsen']);
    Route::get('/home/my-location', [HomeUserController::class, 'myLocation']);

    Route::get('/absen/dashboard', [AbsenUserController::class, 'index']);
    route::get('/absen/dashboard/index',[AbsenUserController::class, 'recordabsen']);

    Route::get('/izin/dashboard', [IzinUserController::class, 'index']);

    Route::get('/history', [HistoryUserController::class, 'index']);

    Route::get('/profile', [ProfileUserController::class, 'index']);

    Route::put('/absen/masuk/{id}', [AbsenController::class, 'absenMasuk']);
    Route::put('/absen/pulang/{id}', [AbsenController::class, 'absenPulang']);
    Route::get('/maps/{lat}/{long}', [AbsenController::class, 'maps']);
    Route::get('/my-absen', [AbsenController::class, 'myAbsen']);
    Route::get('/lembur', [LemburController::class, 'index']);
    Route::post('/lembur/masuk', [LemburController::class, 'masuk']);
    Route::put('/lembur/pulang/{id}', [LemburController::class, 'pulang']);
    Route::get('/my-lembur', [LemburController::class, 'myLembur']);
    Route::get('/cuti', [CutiController::class, 'index']);
    Route::post('/cuti/tambah', [CutiController::class, 'tambah']);
    Route::delete('/cuti/delete/{id}', [CutiController::class, 'delete']);
    Route::get('/cuti/edit/{id}', [CutiController::class, 'edit']);
    Route::put('/cuti/proses-edit/{id}', [CutiController::class, 'editProses']);
    Route::get('/my-profile', [KaryawanController::class, 'myProfile']);
    Route::put('/my-profile/update/{id}', [KaryawanController::class, 'myProfileUpdate']);
    Route::get('/my-profile/edit-password', [KaryawanController::class, 'editPassMyProfile']);
    Route::put('/my-profile/edit-password-proses/{id}', [KaryawanController::class, 'editPassMyProfileProses']);
    Route::get('/my-dokumen', [DokumenController::class, 'myDokumen']);
    Route::get('/my-dokumen/tambah', [DokumenController::class, 'myDokumenTambah']);
    Route::post('/my-dokumen/tambah-proses', [DokumenController::class, 'myDokumenTambahProses']);
    Route::get('/my-dokumen/edit/{id}', [DokumenController::class, 'myDokumenEdit']);
    Route::put('/my-dokumen/edit-proses/{id}', [DokumenController::class, 'myDokumenEditProses']);
    Route::delete('/my-dokumen/delete/{id}', [DokumenController::class, 'myDokumenDelete']);
});
Route::get('/tes', [authController::class, 'tes'])->name('tes');
Route::get('/', [authController::class, 'index'])->name('login')->middleware('guest');
Route::get('/register', [authController::class, 'register'])->middleware('guest');
Route::post('/register-proses', [authController::class, 'registerProses'])->middleware('guest');
Route::post('/login-proses', [authController::class, 'loginProses'])->middleware('guest');
Route::get('/dashboard', [dashboardController::class, 'index'])->middleware('admin');
Route::get('/activity-logs', 'App\Http\Controllers\ActivityLogController@index')->name('activity-logs.index');
// Route::post('/logout', [authController::class, 'logout'])->middleware('auth');
Route::get('/karyawan', [karyawanController::class, 'index'])->middleware('admin');
Route::get('/karyawan/tambah-karyawan', [karyawanController::class, 'tambahKaryawan'])->middleware('admin');
Route::post('/karyawan/tambah-karyawan-proses', [karyawanController::class, 'tambahKaryawanProses'])->middleware('admin');
Route::get('/karyawan/detail/{id}', [karyawanController::class, 'detail'])->middleware('admin');
Route::put('/karyawan/proses-edit/{id}', [karyawanController::class, 'editKaryawanProses'])->middleware('admin');
Route::delete('/karyawan/delete/{id}', [karyawanController::class, 'deleteKaryawan'])->middleware('admin');
Route::get('/karyawan/edit-password/{id}', [karyawanController::class, 'editPassword'])->middleware('admin');
Route::put('/karyawan/edit-password-proses/{id}', [karyawanController::class, 'editPasswordProses'])->middleware('admin');
Route::resource('/shift', ShiftController::class)->middleware('admin');
Route::get('/karyawan/shift/{id}', [karyawanController::class, 'shift'])->middleware('admin');
Route::post('/karyawan/shift/proses-tambah-shift', [karyawanController::class, 'prosesTambahShift'])->middleware('admin');
Route::delete('/karyawan/delete-shift/{id}', [karyawanController::class, 'deleteShift'])->middleware('admin');
Route::get('/karyawan/edit-shift/{id}', [karyawanController::class, 'editShift'])->middleware('admin');
// Route::put('/karyawan/proses-edit-shift/{id}', [karyawanController::class, 'prosesEditShift'])->middleware('auth');
// Route::get('/absen', [AbsenController::class, 'index'])->middleware('auth');
// Route::get('/my-location', [AbsenController::class, 'myLocation'])->middleware('auth');
// Route::put('/absen/masuk/{id}', [AbsenController::class, 'absenMasuk'])->middleware('auth');
// Route::put('/absen/pulang/{id}', [AbsenController::class, 'absenPulang'])->middleware('auth');
Route::get('/data-absen', [AbsenController::class, 'dataAbsen'])->middleware('admin');
Route::get('/data-absen/{id}/edit-masuk', [AbsenController::class, 'editMasuk'])->middleware('admin');
// Route::get('/maps/{lat}/{long}', [AbsenController::class, 'maps'])->middleware('auth');
Route::put('/data-absen/{id}/proses-edit-masuk', [AbsenController::class, 'prosesEditMasuk'])->middleware('admin');
Route::get('/data-absen/{id}/edit-pulang', [AbsenController::class, 'editPulang'])->middleware('admin');
Route::put('/data-absen/{id}/proses-edit-pulang', [AbsenController::class, 'prosesEditPulang'])->middleware('admin');
Route::delete('/data-absen/{id}/delete', [AbsenController::class, 'deleteAdmin'])->middleware('admin');
// Route::get('/my-absen', [AbsenController::class, 'myAbsen'])->middleware('auth');
// Route::get('/lembur', [LemburController::class, 'index'])->middleware('auth');
// Route::post('/lembur/masuk', [LemburController::class, 'masuk'])->middleware('auth');
// Route::put('/lembur/pulang/{id}', [LemburController::class, 'pulang'])->middleware('auth');
Route::get('/data-lembur', [LemburController::class, 'dataLembur'])->middleware('admin');
// Route::get('/my-lembur', [LemburController::class, 'myLembur'])->middleware('auth');
Route::get('/rekap-data', [RekapDataController::class, 'index'])->middleware('admin');
// Route::get('/cuti', [CutiController::class, 'index'])->middleware('auth');
// Route::post('/cuti/tambah', [CutiController::class, 'tambah'])->middleware('auth');
// Route::delete('/cuti/delete/{id}', [CutiController::class, 'delete'])->middleware('auth');
// Route::get('/cuti/edit/{id}', [CutiController::class, 'edit'])->middleware('auth');
// Route::put('/cuti/proses-edit/{id}', [CutiController::class, 'editProses'])->middleware('auth');
Route::get('/data-cuti', [CutiController::class, 'dataCuti'])->middleware('admin');
Route::get('/data-cuti/tambah', [CutiController::class, 'tambahAdmin'])->middleware('admin');
Route::post('/data-cuti/getuserid', [CutiController::class, 'getUserId'])->middleware('admin');
Route::post('/data-cuti/proses-tambah', [CutiController::class, 'tambahAdminProses'])->middleware('admin');
Route::delete('/data-cuti/delete/{id}', [CutiController::class, 'deleteAdmin'])->middleware('admin');
Route::get('/data-cuti/edit/{id}', [CutiController::class, 'editAdmin'])->middleware('admin');
Route::put('/data-cuti/edit-proses/{id}', [CutiController::class, 'editAdminProses'])->middleware('admin');
// Route::get('/my-profile', [KaryawanController::class, 'myProfile'])->middleware('auth');
// Route::put('/my-profile/update/{id}', [KaryawanController::class, 'myProfileUpdate'])->middleware('auth');
// Route::get('/my-profile/edit-password', [KaryawanController::class, 'editPassMyProfile'])->middleware('auth');
// Route::put('/my-profile/edit-password-proses/{id}', [KaryawanController::class, 'editPassMyProfileProses'])->middleware('auth');
Route::get('/lokasi-kantor', [LokasiController::class, 'index'])->middleware('admin');
Route::put('/lokasi-kantor/{id}', [LokasiController::class, 'updateLokasi'])->middleware('admin');
Route::put('/lokasi-kantor/radius/{id}', [LokasiController::class, 'updateRadiusLokasi'])->middleware('admin');
Route::get('/reset-cuti', [KaryawanController::class, 'resetCuti'])->middleware('admin');
Route::put('/reset-cuti/{id}', [KaryawanController::class, 'resetCutiProses'])->middleware('admin');
Route::get('/jabatan', [jabatanController::class, 'index'])->middleware('admin');
Route::get('/jabatan/create', [jabatanController::class, 'create'])->middleware('admin');
Route::post('/jabatan/insert', [jabatanController::class, 'insert'])->middleware('admin');
Route::get('/jabatan/edit/{id}', [jabatanController::class, 'edit'])->middleware('admin');
Route::put('/jabatan/update/{id}', [jabatanController::class, 'update'])->middleware('admin');
Route::delete('/jabatan/delete/{id}', [jabatanController::class, 'delete'])->middleware('admin');
Route::get('/dokumen', [DokumenController::class, 'index'])->middleware('admin');
Route::get('/dokumen/tambah', [DokumenController::class, 'tambah'])->middleware('admin');
Route::post('/dokumen/tambah-proses', [DokumenController::class, 'tambahProses'])->middleware('admin');
Route::get('/dokumen/edit/{id}', [DokumenController::class, 'edit'])->middleware('admin');
Route::put('/dokumen/edit-proses/{id}', [DokumenController::class, 'editProses'])->middleware('admin');
Route::delete('/dokumen/delete/{id}', [DokumenController::class, 'delete'])->middleware('admin');
// Route::get('/my-dokumen', [DokumenController::class, 'myDokumen'])->middleware('auth');
// Route::get('/my-dokumen/tambah', [DokumenController::class, 'myDokumenTambah'])->middleware('auth');
// Route::post('/my-dokumen/tambah-proses', [DokumenController::class, 'myDokumenTambahProses'])->middleware('auth');
// Route::get('/my-dokumen/edit/{id}', [DokumenController::class, 'myDokumenEdit'])->middleware('auth');
// Route::put('/my-dokumen/edit-proses/{id}', [DokumenController::class, 'myDokumenEditProses'])->middleware('auth');
// Route::delete('/my-dokumen/delete/{id}', [DokumenController::class, 'myDokumenDelete'])->middleware('auth');
Route::post('/logout', [authController::class, 'logout'])->name('logout');

Route::get('optimize', function () {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('optimize:clear');


    Artisan::call('view:cache');
    Artisan::call('route:cache');
    Artisan::call('config:cache');
    Artisan::call('optimize');

    echo 'optimize clear';
});
