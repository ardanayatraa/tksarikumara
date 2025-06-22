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
            'email'                 => 'required|string|email|max:255|unique:akun_siswa,email',
            'password'              => ['required','confirmed', Password::defaults()],

        ]);

        // Buat user baru
        $user = AkunSiswa::create([
            'namaSiswa'   => $data['name'],
            'email'       => $data['email'],
            // buat username dari slug nama (atau ganti sesuai kebutuhan)
            'username'    => Str::slug($data['name'], '_'),
            'password'    => Hash::make($data['password']),
        ]);



        return redirect()->to('/dashboard');
    }
}
