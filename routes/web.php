<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CustomAuthenticatedSessionController;
use App\Http\Livewire\AkunSiswa\Profil;
use App\Mail\MailToParent;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Auth\RegisterController;

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
    return view('landing-page');
});


Route::post('/login', [CustomAuthenticatedSessionController::class, 'store'])->name('login');

Route::post('/logout', [CustomAuthenticatedSessionController::class, 'destroy'])
    ->name('logout');


Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});



// Siswa
Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard.siswa');
    Route::get('/profil-siswa', function () {
        return view('siswa.profil');
    })->name('profil.siswa');

});

// Admin
Route::middleware([ 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::get('/admin/data-akun', function () {
        return view('admin.data-account');
    })->name('admin.data-account');
    Route::get('/admin/master-data', function () {
        return view('admin.master-data');
    })->name('admin.master-data');

      Route::get('/profil-admin', function () {
        return view('admin.profil');
    })->name('profil.admin');

});

// Guru
Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/guru/dashboard', function () {
        return view('guru.dashboard');
    })->name('guru.dashboard');
    Route::get('/guru/aspek-penilaian', function () {
        return view('guru.aspek-penilaian');
    })->name('guru.aspek-penilaian');
    Route::get('/guru/kategori', function () {
        return view('guru.kategori');
    })->name('guru.kategori');
    Route::get('/guru/penilaian', function () {
        return view('guru.penilaian');
    })->name('guru.penilaian');
    Route::get('/guru/penilaian/{id}', function ($id) {
        return view('guru.penilaian-detail', ['id' => $id]);
    })->name('guru.penilaian.detail');

     Route::get('/profil-guru', function () {
        return view('guru.profil');
    })->name('profil.guru');

});


// Kepala Sekolah
Route::middleware(['auth', 'role:kepsek'])->group(function () {
    Route::get('/kepsek/dashboard', function () {
        return view('kepsek.dashboard');
    })->name('dashboard.kepsek');
    Route::get('/kepsek/penilaian', function () {
        return view('kepsek.penilaian');
    })->name('penilaian.kepsek');

       Route::get('kepsek/profil-kepala-sekolah', function () {
        return view('kepsek.profil');
    })->name('profil.kepala-sekolah');

        Route::get('/kepsek/penilaian/{id}', function ($id) {
        return view('kepsek.penilaian-detail', ['id' => $id]);
    })->name('kepsek.penilaian.detail');

});


Route::get('/kirim', function () {
    $namaAnak = 'Made';
    $emailOrtu = 'ardanapastibisa@gmail.com';

    Mail::to($emailOrtu)->send(new MailToParent($namaAnak));

    return 'Email plus lampiran berhasil dikirim ke orang tua dari ' . $namaAnak;
});
