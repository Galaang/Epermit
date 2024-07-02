<?php

use App\Http\Controllers\Auth_controller;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\pegawaiController;
use App\Http\Controllers\perizinan;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

//dashboard
Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');

//login
Route::get('/', [Auth_controller::class, 'loginview'])->name('loginview');
Route::post('/login', [Auth_controller::class, 'login'])->name('login');

//logout
Route::post('/logout', [Auth_controller::class, 'logout'])->name('logout');

// Route::middleware(['auth', 'role:2'])->group(function () {
    Route::get('/data_permohonan', [perizinan::class, 'data_permohonan'])->name('data_permohonan');
    Route::get('/data_permohonan_kajur', [perizinan::class, 'data_permohonan_kajur'])->name('data_permohonan_kajur');
    Route::get('/data_permohonan_wadir', [perizinan::class, 'data_permohonan_wadir'])->name('data_permohonan_wadir');
    // });

// Route::middleware(['auth', 'role:1'])->group(function () {
    Route::get('/form', [perizinan::class, 'form_izin'])->name('form_izin');
    Route::post('/form-insert', [perizinan::class, 'insert'])->name('form-insert');
    Route::get('/riwayat_permohonan', [perizinan::class, 'riwayat_permohonan'])->name('riwayat_permohonan');
    Route::post('/edit-respon/{id}', [perizinan::class, 'editRespon'])->name('edit_respon');
// });

// profile
Route::get('/profile', [Auth_controller::class, 'profile'])->name('profile');
Route::post('/profile', [Auth_controller::class, 'editProfile'])->name('edit_profile');

//perizinan
Route::get('/riwayatPermohonan', [perizinan::class, 'riwayatpermohonanBaup'])->name('riwayatpermohonanBaup');
Route::get('/data_permohonan', [perizinan::class, 'data_permohonan'])->name('data_permohonan');

Route::match(['get', 'post'], '/update/data_permohonan/{id}', [perizinan::class, 'update'])->name('update');

//pegawai
Route::get('/pegawai', [pegawaiController::class, 'pegawai'])->name('pegawai');
Route::post('/tambah-pegawai', [pegawaiController::class, 'tambahPegawai'])->name('tambah-pegawai');
Route::delete('/hapus-pegawai/{id}', [pegawaiController::class, 'hapusPegawai'])->name('hapus-pegawai');
Route::post('/edit-pegawai/{id}', [pegawaiController::class, 'editPegawai'])->name('edit-pegawai');

Route::get('/unit-kerja', [pegawaiController::class, 'unitKerja'])->name('unit-kerja');
Route::post('/tambah-unit', [pegawaiController::class, 'tambahUnitKerja'])->name('tambah-unit-kerja');
Route::post('/edit-unit/{id}', [pegawaiController::class, 'editUnitKerja'])->name('edit-unit-kerja');

Route::get('/pangkat-jabatan', [pegawaiController::class, 'pangkatJabatan'])->name('pangkat-jabatan');
Route::post('/tambah-pangkat', [pegawaiController::class, 'tambahPangkatJabatan'])->name('tambah-pangkat-jabatan');
Route::delete('/hapus-pangkat/{id}', [pegawaiController::class, 'hapusPangkatJabatan'])->name('hapus-pangkat-jabatan');
Route::post('/edit-pangkat/{id}', [pegawaiController::class, 'editPangkatJabatan'])->name('edit-pangkat-jabatan');

Route::post('/tambah-jabatan', [pegawaiController::class, 'tambahJabatan'])->name('tambah-jabatan');
Route::get('/jabatan', [pegawaiController::class, 'jabatan'])->name('jabatan');
Route::post('/edit-jabatan/{id}', [pegawaiController::class, 'editJabatan'])->name('edit-jabatan');
