<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\AkunSiswa;
use App\Models\Guru;
use App\Models\KepalaSekolah;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Features;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Fortify::username(function () {
            return 'username';
        });


        Fortify::authenticateUsing(function (Request $request) {
            $username = $request->input('username');
            $password = $request->input('password');

            // Cek dari tabel akun_siswa
            $siswa = AkunSiswa::where('username', $username)->first();
            if ($siswa && Hash::check($password, $siswa->password)) {
                session(['role' => 'siswa']);
                Auth::guard('siswa')->login($siswa); // Login dengan guard siswa
                return $siswa;
            }

            // Cek dari tabel guru
            $guru = Guru::where('username', $username)->first();
            if ($guru && Hash::check($password, $guru->password)) {
                session(['role' => 'guru']);
                Auth::guard('guru')->login($guru); // Login dengan guard guru
                return $guru;
            }

            // Cek dari tabel admin
            $admin = Admin::where('username', $username)->first();
            if ($admin && Hash::check($password, $admin->password)) {
                session(['role' => 'admin']);
                Auth::guard('admin')->login($admin); // Login dengan guard admin
                return $admin;
            }

            // Cek dari tabel kepala_sekolah
            $kepsek = KepalaSekolah::where('username', $username)->first();
            if ($kepsek && Hash::check($password, $kepsek->password)) {
                session(['role' => 'kepsek']);
                Auth::guard('kepsek')->login($kepsek); // Login dengan guard kepsek
                return $kepsek;
            }

            return null;
        });




        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::loginView(function () {
            return view('auth.login'); // Ubah kalau mau pake view lain
        });

    }
}
