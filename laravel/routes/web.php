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
use App\Http\Controllers\SP\dashboardSPController;
use App\Http\Controllers\dashboardSPSController;
use App\Http\Controllers\dashboardSIPController;
use App\Http\Controllers\RekapDataController;
use App\Http\Controllers\HomeUserController;
use App\Http\Controllers\HistoryUserController;
use App\Http\Controllers\ProfileUserController;
use App\Http\Controllers\AbsenUserController;
use App\Http\Controllers\IzinUserController;
use App\Http\Controllers\CutiUserController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\PenugasanController;
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

Route::middleware('auth', 'log.activity')->group(function () {
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

    Route::get('/home', [HomeUserController::class, 'index'])->name('home');
    Route::put('/home/absen/masuk/{id}', [HomeUserController::class, 'absenMasuk']);
    Route::get('/datatableHome', [HomeUserController::class, 'datatableHome'])->name('datatableHome');
    Route::get('/get_count_absensi_home', [HomeUserController::class, 'get_count_absensi_home'])->name('get_count_absensi_home');
    Route::get('/home/absen', [HomeUserController::class, 'HomeAbsen']);
    Route::put('/home/absen/pulang/{id}', [HomeUserController::class, 'absenPulang']);
    Route::get('/home/maps/{lat}/{long}', [HomeUserController::class, 'maps']);
    Route::get('/home/my-absen', [HomeUserController::class, 'myAbsen']);
    Route::get('/home/my-location', [HomeUserController::class, 'myLocation']);

    Route::get('/absen/dashboard', [AbsenUserController::class, 'index']);
    route::get('/absen/dashboard/index', [AbsenUserController::class, 'recordabsen']);

    Route::get('/izin/dashboard', [IzinUserController::class, 'index']);
    Route::put('/izin/tambah-izin-proses', [IzinUserController::class, 'izinAbsen']);
    Route::get('/izin/approve/{id}', [IzinUserController::class, 'izinApprove']);
    Route::put('/izin/approve/proses/{id}', [IzinUserController::class, 'izinApproveProses']);

    Route::get('/cuti/dashboard', [CutiUserController::class, 'index']);
    Route::get('/cuti/approve/{id}', [CutiUserController::class, 'cutiApprove']);
    Route::put('/cuti/tambah-cuti-proses', [CutiUserController::class, 'cutiAbsen']);
    Route::put('/cuti/approve/proses/{id}', [CutiUserController::class, 'cutiApproveProses']);

    Route::get('/penugasan/dashboard', [PenugasanController::class, 'index']);
    Route::get('/penugasan/approve/diminta/{id}', [PenugasanController::class, 'penugasanApprove']);
    Route::get('/penugasan/approve/disahkan/{id}', [PenugasanController::class, 'penugasanApprove']);
    Route::get('/penugasan/approve/diproseshrd/{id}', [PenugasanController::class, 'penugasanApprove']);
    Route::get('/penugasan/approve/diprosesfinance/{id}', [PenugasanController::class, 'penugasanApprove']);
    Route::get('/penugasan/detail/edit/{id}', [PenugasanController::class, 'penugasanEdit']);
    Route::get('/penugasan/detail/update/{id}', [PenugasanController::class, 'penugasanUpdate']);
    Route::get('/penugasan/delete/{id}', [PenugasanController::class, 'penugasanDelete']);
    Route::put('/penugasan/tambah-penugasan-proses', [PenugasanController::class, 'tambahPenugasan']);
    Route::put('/penugasan/approve/proses/{id}', [PenugasanController::class, 'penugasanApproveProses']);

    Route::get('/history', [HistoryUserController::class, 'index'])->name('history');

    Route::get('/profile', [ProfileUserController::class, 'index'])->name('profile');

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
Route::get('/dashboard/holding/sp', [dashboardController::class, 'index'])->middleware('admin');
Route::get('/dashboard/holding/sps', [dashboardController::class, 'index'])->middleware('admin');
Route::get('/dashboard/holding/sip', [dashboardController::class, 'index'])->middleware('admin');
Route::get('/dashboard/holding', [dashboardController::class, 'holding'])->middleware('admin');
Route::get('/activity-logs', 'App\Http\Controllers\ActivityLogController@index')->name('activity-logs.index');
// Route::post('/logout', [authController::class, 'logout'])->middleware('auth');
Route::get('/karyawan/sp', [karyawanController::class, 'index'])->middleware('admin');
Route::get('/karyawan/sps', [karyawanController::class, 'index'])->middleware('admin');
Route::get('/karyawan/sip', [karyawanController::class, 'index'])->middleware('admin');
Route::get('/karyawan/tambah-karyawan/sp', [karyawanController::class, 'tambahKaryawan'])->middleware('admin');
Route::get('/karyawan/tambah-karyawan/sps', [karyawanController::class, 'tambahKaryawan'])->middleware('admin');
Route::get('/karyawan/tambah-karyawan/sip', [karyawanController::class, 'tambahKaryawan'])->middleware('admin');
Route::post('/karyawan/tambah-karyawan-proses/sp', [karyawanController::class, 'tambahKaryawanProses'])->middleware('admin');
Route::post('/karyawan/tambah-karyawan-proses/sps', [karyawanController::class, 'tambahKaryawanProses'])->middleware('admin');
Route::post('/karyawan/tambah-karyawan-proses/sip', [karyawanController::class, 'tambahKaryawanProses'])->middleware('admin');
Route::get('/karyawan/detail/{id}/sp', [karyawanController::class, 'detail'])->middleware('admin');
Route::get('/karyawan/detail/{id}/sps', [karyawanController::class, 'detail'])->middleware('admin');
Route::get('/karyawan/detail/{id}/sip', [karyawanController::class, 'detail'])->middleware('admin');
Route::put('/karyawan/proses-edit/{id}/sp', [karyawanController::class, 'editKaryawanProses'])->middleware('admin');
Route::put('/karyawan/proses-edit/{id}/sps', [karyawanController::class, 'editKaryawanProses'])->middleware('admin');
Route::put('/karyawan/proses-edit/{id}/sip', [karyawanController::class, 'editKaryawanProses'])->middleware('admin');
Route::delete('/karyawan/delete/{id}/sp', [karyawanController::class, 'deleteKaryawan'])->middleware('admin');
Route::delete('/karyawan/delete/{id}/sps', [karyawanController::class, 'deleteKaryawan'])->middleware('admin');
Route::delete('/karyawan/delete/{id}/sip', [karyawanController::class, 'deleteKaryawan'])->middleware('admin');
Route::get('/karyawan/edit-password/{id}', [karyawanController::class, 'editPassword'])->middleware('admin');
Route::put('/karyawan/edit-password-proses/{id}', [karyawanController::class, 'editPasswordProses'])->middleware('admin');
Route::get('/shift/sp', [ShiftController::class, 'index'])->middleware('admin');
Route::get('/shift/sps', [ShiftController::class, 'index'])->middleware('admin');
Route::get('/shift/sip', [ShiftController::class, 'index'])->middleware('admin');
Route::get('/shift/edit/{id}/sp', [ShiftController::class, 'edit'])->middleware('admin');
Route::get('/shift/edit/{id}/sps', [ShiftController::class, 'edit'])->middleware('admin');
Route::get('/shift/edit/{id}/sip', [ShiftController::class, 'edit'])->middleware('admin');
Route::get('/shift/create/sp', [ShiftController::class, 'create'])->middleware('admin');
Route::get('/shift/create/sps', [ShiftController::class, 'create'])->middleware('admin');
Route::get('/shift/create/sip', [ShiftController::class, 'create'])->middleware('admin');
Route::post('/shift/store/sp', [ShiftController::class, 'store'])->middleware('admin');
Route::post('/shift/store/sps', [ShiftController::class, 'store'])->middleware('admin');
Route::post('/shift/store/sip', [ShiftController::class, 'store'])->middleware('admin');
Route::put('/shift/update/{id}/sp', [ShiftController::class, 'update'])->middleware('admin');
Route::put('/shift/update/{id}/sps', [ShiftController::class, 'update'])->middleware('admin');
Route::put('/shift/update/{id}/sip', [ShiftController::class, 'update'])->middleware('admin');
Route::delete('/shift/delete/{id}/sp', [ShiftController::class, 'destroy'])->middleware('admin');
Route::delete('/shift/delete/{id}/sps', [ShiftController::class, 'destroy'])->middleware('admin');
Route::delete('/shift/delete/{id}/sip', [ShiftController::class, 'destroy'])->middleware('admin');
Route::get('/karyawan/shift/{id}/sp', [karyawanController::class, 'shift'])->middleware('admin');
Route::get('/karyawan/shift/{id}/sps', [karyawanController::class, 'shift'])->middleware('admin');
Route::get('/karyawan/shift/{id}/sip', [karyawanController::class, 'shift'])->middleware('admin');
Route::post('/karyawan/shift/proses-tambah-shift/sp', [karyawanController::class, 'prosesTambahShift'])->middleware('admin');
Route::post('/karyawan/shift/proses-tambah-shift/sps', [karyawanController::class, 'prosesTambahShift'])->middleware('admin');
Route::post('/karyawan/shift/proses-tambah-shift/sip', [karyawanController::class, 'prosesTambahShift'])->middleware('admin');
Route::delete('/karyawan/delete-shift/{id}/sp', [karyawanController::class, 'deleteShift'])->middleware('admin');
Route::delete('/karyawan/delete-shift/{id}/sps', [karyawanController::class, 'deleteShift'])->middleware('admin');
Route::delete('/karyawan/delete-shift/{id}/sip', [karyawanController::class, 'deleteShift'])->middleware('admin');
Route::get('/karyawan/edit-shift/{id}/sp', [karyawanController::class, 'editShift'])->middleware('admin');
Route::get('/karyawan/edit-shift/{id}/sps', [karyawanController::class, 'editShift'])->middleware('admin');
Route::get('/karyawan/edit-shift/{id}/sip', [karyawanController::class, 'editShift'])->middleware('admin');
//
Route::get('/karyawan/get_divisi', [karyawanController::class, 'get_divisi'])->middleware('admin');
Route::get('/karyawan/get_jabatan', [karyawanController::class, 'get_jabatan'])->middleware('admin');

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
Route::get('/rekap-data/sp', [RekapDataController::class, 'index'])->middleware('admin');
Route::get('/rekap-data/sps', [RekapDataController::class, 'index'])->middleware('admin');
Route::get('/rekap-data/sip', [RekapDataController::class, 'index'])->middleware('admin');
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
Route::get('/lokasi-kantor/sp', [LokasiController::class, 'index'])->middleware('admin');
Route::get('/lokasi-kantor/sps', [LokasiController::class, 'index'])->middleware('admin');
Route::get('/lokasi-kantor/sip', [LokasiController::class, 'index'])->middleware('admin');
Route::post('/lokasi-kantor/add/sp', [LokasiController::class, 'addLokasi'])->middleware('admin');
Route::post('/lokasi-kantor/add/sps', [LokasiController::class, 'addLokasi'])->middleware('admin');
Route::post('/lokasi-kantor/add/sip', [LokasiController::class, 'addLokasi'])->middleware('admin');
Route::post('/lokasi-kantor/edit/sp', [LokasiController::class, 'updateLokasi'])->middleware('admin');
Route::post('/lokasi-kantor/edit/sps', [LokasiController::class, 'updateLokasi'])->middleware('admin');
Route::post('/lokasi-kantor/edit/sip', [LokasiController::class, 'updateLokasi'])->middleware('admin');
Route::get('/lokasi-kantor/delete/{id}/sp', [LokasiController::class, 'deleteLokasi'])->middleware('admin');
Route::get('/lokasi-kantor/delete/{id}/sps', [LokasiController::class, 'deleteLokasi'])->middleware('admin');
Route::get('/lokasi-kantor/delete/{id}/sip', [LokasiController::class, 'deleteLokasi'])->middleware('admin');
Route::put('/lokasi-kantor/radius/{id}/sp', [LokasiController::class, 'updateRadiusLokasi'])->middleware('admin');
Route::put('/lokasi-kantor/radius/{id}/sps', [LokasiController::class, 'updateRadiusLokasi'])->middleware('admin');
Route::put('/lokasi-kantor/radius/{id}/sip', [LokasiController::class, 'updateRadiusLokasi'])->middleware('admin');
Route::get('/reset-cuti/sp', [KaryawanController::class, 'resetCuti'])->middleware('admin');
Route::get('/reset-cuti/sps', [KaryawanController::class, 'resetCuti'])->middleware('admin');
Route::get('/reset-cuti/sip', [KaryawanController::class, 'resetCuti'])->middleware('admin');
Route::put('/reset-cuti/{id}/sp', [KaryawanController::class, 'resetCutiProses'])->middleware('admin');
Route::put('/reset-cuti/{id}/sps', [KaryawanController::class, 'resetCutiProses'])->middleware('admin');
Route::put('/reset-cuti/{id}/sip', [KaryawanController::class, 'resetCutiProses'])->middleware('admin');
// MASTER DEPARTEMEN
Route::get('/departemen/sp', [DepartemenController::class, 'index'])->middleware('admin');
Route::get('/departemen/sps', [DepartemenController::class, 'index'])->middleware('admin');
Route::get('/departemen/sip', [DepartemenController::class, 'index'])->middleware('admin');
Route::get('/departemen/create/sp', [DepartemenController::class, 'create'])->middleware('admin');
Route::get('/departemen/create/sps', [DepartemenController::class, 'create'])->middleware('admin');
Route::get('/departemen/create/sip', [DepartemenController::class, 'create'])->middleware('admin');
Route::post('/departemen/insert/sp', [DepartemenController::class, 'insert'])->middleware('admin');
Route::post('/departemen/insert/sps', [DepartemenController::class, 'insert'])->middleware('admin');
Route::post('/departemen/insert/sip', [DepartemenController::class, 'insert'])->middleware('admin');
Route::get('/departemen/edit/{id}/sp', [DepartemenController::class, 'edit'])->middleware('admin');
Route::get('/departemen/edit/{id}/sps', [DepartemenController::class, 'edit'])->middleware('admin');
Route::get('/departemen/edit/{id}/sip', [DepartemenController::class, 'edit'])->middleware('admin');
Route::put('/departemen/update/{id}/sp', [DepartemenController::class, 'update'])->middleware('admin');
Route::put('/departemen/update/{id}/sps', [DepartemenController::class, 'update'])->middleware('admin');
Route::put('/departemen/update/{id}/sip', [DepartemenController::class, 'update'])->middleware('admin');
Route::delete('/departemen/delete/{id}/sp', [DepartemenController::class, 'delete'])->middleware('admin');
Route::delete('/departemen/delete/{id}/sps', [DepartemenController::class, 'delete'])->middleware('admin');
Route::delete('/departemen/delete/{id}/sip', [DepartemenController::class, 'delete'])->middleware('admin');
// MASTER DIVISI
Route::get('/divisi/sp', [DivisiController::class, 'index'])->middleware('admin');
Route::get('/divisi/sps', [DivisiController::class, 'index'])->middleware('admin');
Route::get('/divisi/sip', [DivisiController::class, 'index'])->middleware('admin');
Route::get('/divisi/create/sp', [DivisiController::class, 'create'])->middleware('admin');
Route::get('/divisi/create/sps', [DivisiController::class, 'create'])->middleware('admin');
Route::get('/divisi/create/sip', [DivisiController::class, 'create'])->middleware('admin');
Route::post('/divisi/insert/sp', [DivisiController::class, 'insert'])->middleware('admin');
Route::post('/divisi/insert/sps', [DivisiController::class, 'insert'])->middleware('admin');
Route::post('/divisi/insert/sip', [DivisiController::class, 'insert'])->middleware('admin');
Route::get('/divisi/edit/{id}/sp', [DivisiController::class, 'edit'])->middleware('admin');
Route::get('/divisi/edit/{id}/sps', [DivisiController::class, 'edit'])->middleware('admin');
Route::get('/divisi/edit/{id}/sip', [DivisiController::class, 'edit'])->middleware('admin');
Route::put('/divisi/update/{id}/sp', [DivisiController::class, 'update'])->middleware('admin');
Route::put('/divisi/update/{id}/sps', [DivisiController::class, 'update'])->middleware('admin');
Route::put('/divisi/update/{id}/sip', [DivisiController::class, 'update'])->middleware('admin');
Route::delete('/divisi/delete/{id}/sp', [DivisiController::class, 'delete'])->middleware('admin');
Route::delete('/divisi/delete/{id}/sps', [DivisiController::class, 'delete'])->middleware('admin');
Route::delete('/divisi/delete/{id}/sip', [DivisiController::class, 'delete'])->middleware('admin');
// MASTER JABATAN
Route::get('/jabatan/sp', [jabatanController::class, 'index'])->middleware('admin');
Route::get('/jabatan/sps', [jabatanController::class, 'index'])->middleware('admin');
Route::get('/jabatan/sip', [jabatanController::class, 'index'])->middleware('admin');
Route::get('/jabatan/create/sp', [jabatanController::class, 'create'])->middleware('admin');
Route::get('/jabatan/create/sps', [jabatanController::class, 'create'])->middleware('admin');
Route::get('/jabatan/create/sip', [jabatanController::class, 'create'])->middleware('admin');
Route::post('/jabatan/insert/sp', [jabatanController::class, 'insert'])->middleware('admin');
Route::post('/jabatan/insert/sps', [jabatanController::class, 'insert'])->middleware('admin');
Route::post('/jabatan/insert/sip', [jabatanController::class, 'insert'])->middleware('admin');
Route::get('/jabatan/edit/{id}/sp', [jabatanController::class, 'edit'])->middleware('admin');
Route::get('/jabatan/edit/{id}/sps', [jabatanController::class, 'edit'])->middleware('admin');
Route::get('/jabatan/edit/{id}/sip', [jabatanController::class, 'edit'])->middleware('admin');
Route::put('/jabatan/update/{id}/sp', [jabatanController::class, 'update'])->middleware('admin');
Route::put('/jabatan/update/{id}/sps', [jabatanController::class, 'update'])->middleware('admin');
Route::put('/jabatan/update/{id}/sip', [jabatanController::class, 'update'])->middleware('admin');
Route::delete('/jabatan/delete/{id}/sp', [jabatanController::class, 'delete'])->middleware('admin');
Route::delete('/jabatan/delete/{id}/sps', [jabatanController::class, 'delete'])->middleware('admin');
Route::delete('/jabatan/delete/{id}/sip', [jabatanController::class, 'delete'])->middleware('admin');

// GET ALAMAT
Route::get('/karyawan/get_kabupaten/{id}', [karyawanController::class, 'get_kabupaten'])->middleware('admin');
Route::get('/karyawan/get_kecamatan/{id}', [karyawanController::class, 'get_kecamatan'])->middleware('admin');
Route::get('/karyawan/get_desa/{id}', [karyawanController::class, 'get_desa'])->middleware('admin');
// DOKUMEN
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
