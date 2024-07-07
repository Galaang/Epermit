<?php

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\perizinan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Auth_controller;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\pegawaiController;
use App\Http\Controllers\dashboardController;

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

// reset password
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('loginview')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');



Route::middleware(['auth', 'role:2'])->group(function () {
    Route::get('/data_permohonan', [perizinan::class, 'data_permohonan'])->name('data_permohonan');
    Route::get('/data_permohonan_kajur', [perizinan::class, 'data_permohonan_kajur'])->name('data_permohonan_kajur');
});

Route::middleware(['auth', 'role:3'])->group(function () {
    Route::get('/data_permohonan', [perizinan::class, 'data_permohonan'])->name('data_permohonan');
    Route::get('/data_permohonan_wadir', [perizinan::class, 'data_permohonan_wadir1'])->name('data_permohonan_wadir');
    Route::get('/data_permohonan_wadir2', [perizinan::class, 'data_permohonan_wadir2'])->name('data_permohonan_wadir2');
});

Route::middleware(['auth', 'role:1,2,3,4'])->group(function () {
    // profile
    Route::get('/profile', [Auth_controller::class, 'profile'])->name('profile');
    Route::post('/profile', [Auth_controller::class, 'editProfile'])->name('edit_profile');

    // form perizinan
    Route::get('/form', [perizinan::class, 'form_izin'])->name('form_izin');
    Route::post('/form-insert', [perizinan::class, 'insert'])->name('form-insert');
    Route::get('/riwayat_permohonan', [perizinan::class, 'riwayat_permohonan'])->name('riwayat_permohonan');
    Route::post('/edit-respon/{id}', [perizinan::class, 'editRespon'])->name('edit_respon');
    Route::match(['get', 'post'], '/update/data_permohonan/{id}', [perizinan::class, 'update'])->name('update');
});

Route::middleware(['auth', 'role:4'])->group(function () {
    // riwayat perizinan
    Route::get('/riwayatPermohonan', [perizinan::class, 'riwayatpermohonanBaup'])->name('riwayatpermohonanBaup');

    //menu pegawai
    Route::get('/pegawai', [pegawaiController::class, 'pegawai'])->name('pegawai');
    Route::post('/tambah-pegawai', [pegawaiController::class, 'tambahPegawai'])->name('tambah-pegawai');
    Route::delete('/hapus-pegawai/{id}', [pegawaiController::class, 'hapusPegawai'])->name('hapus-pegawai');
    Route::post('/edit-pegawai/{id}', [pegawaiController::class, 'editPegawai'])->name('edit-pegawai');

    // menu unit kerja
    Route::get('/unit-kerja', [pegawaiController::class, 'unitKerja'])->name('unit-kerja');
    Route::post('/tambah-unit', [pegawaiController::class, 'tambahUnitKerja'])->name('tambah-unit-kerja');
    Route::post('/edit-unit/{id}', [pegawaiController::class, 'editUnitKerja'])->name('edit-unit-kerja');

    // menu pangkat jabatan
    Route::get('/pangkat-jabatan', [pegawaiController::class, 'pangkatJabatan'])->name('pangkat-jabatan');
    Route::post('/tambah-pangkat', [pegawaiController::class, 'tambahPangkatJabatan'])->name('tambah-pangkat-jabatan');
    Route::delete('/hapus-pangkat/{id}', [pegawaiController::class, 'hapusPangkatJabatan'])->name('hapus-pangkat-jabatan');
    Route::post('/edit-pangkat/{id}', [pegawaiController::class, 'editPangkatJabatan'])->name('edit-pangkat-jabatan');

    // menu jabatan
    Route::post('/tambah-jabatan', [pegawaiController::class, 'tambahJabatan'])->name('tambah-jabatan');
    Route::get('/jabatan', [pegawaiController::class, 'jabatan'])->name('jabatan');
    Route::post('/edit-jabatan/{id}', [pegawaiController::class, 'editJabatan'])->name('edit-jabatan');
});
