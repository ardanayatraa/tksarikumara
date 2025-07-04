<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AkunSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Tampilkan form registrasi (sesuaikan view-nya jika bukan di auth.register)
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Proses registrasi.
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'                  => 'required|string|max:255',
            'tgl_lahir'             => 'required|date',
            'email'                 => 'required|string|email|max:255|unique:akun_siswa,email',
            'password'              => ['required','confirmed', Password::defaults()],

        ]);

        // hitung tanggal lagir dan tanggal sekarang sehingga dapat umur
        $tgl_lahir = \Carbon\Carbon::parse($data['tgl_lahir']);
        $umur = $tgl_lahir->diffInYears(now());

        //jika umur di rentang 2-4 itu id kelas nya 1 kalau 5-6 itu id kelas nya 2
        $id_kelas = null;
        if ($umur >= 2 && $umur <= 4) {
            $id_kelas = 1; // Kelas TK A
        } elseif ($umur >= 5 && $umur <= 6) {
            $id_kelas = 2; // Kelas TK B
        } else {
            return redirect()->back()->withErrors(['Umur tidak sesuai untuk pendaftaran.']);
        }
        // Buat user baru
        $user = AkunSiswa::create([
            'namaSiswa'   => $data['name'],
            'email'       => $data['email'],
            // buat username dari slug nama (atau ganti sesuai kebutuhan)
            'username'    => Str::slug($data['name'], '_'),
            'id_kelas'    => $id_kelas,
            'tgl_lahir'   => $data['tgl_lahir'],
            'password'    => Hash::make($data['password']),
        ]);



        return redirect()->to('/dashboard');
    }
}
