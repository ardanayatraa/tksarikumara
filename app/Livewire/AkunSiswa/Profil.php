<?php

namespace App\Livewire\AkunSiswa;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\AkunSiswa;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Profil extends Component
{
    use WithFileUploads;

    // Properti untuk form
    public $id_akunsiswa;
    public $id_kelas;
    public $nisn;
    public $namaSiswa;
    public $namaOrangTua;
    public $tgl_lahir;
    public $jenis_kelamin;
    public $alamat;
    public $email;
    public $username;
    public $password;      // Opsional: jika ingin ubah password
    public $foto;          // Upload file baru
    public $fotoPreview;   // Path foto lama

    public function mount()
    {
        // Ambil data siswa berdasarkan yang sedang login (guard 'siswa')
        /**
         * Catatan: Pastikan di config/auth.php guard 'siswa' mengembalikan model AkunSiswa.
         * Misalnya:
         * 'guards' => [
         *     'siswa' => [
         *         'driver' => 'session',
         *         'provider' => 'akunsiswa',
         *     ],
         * ],
         * 'providers' => [
         *     'akunsiswa' => [
         *         'driver' => 'eloquent',
         *         'model' => App\Models\AkunSiswa::class,
         *     ],
         * ],
         */
        $siswa = Auth::guard('siswa')->user();

        if (!$siswa) {
            abort(403); // Jika belum login atau bukan siswa
        }

        // Isi properti dengan data yang sudah ada
        $this->id_akunsiswa  = $siswa->id_akunsiswa;
        $this->id_kelas      = $siswa->id_kelas;
        $this->nisn          = $siswa->nisn;
        $this->namaSiswa     = $siswa->namaSiswa;
        $this->namaOrangTua  = $siswa->namaOrangTua;
        $this->tgl_lahir     = $siswa->tgl_lahir;
        $this->jenis_kelamin = $siswa->jenis_kelamin;
        $this->alamat        = $siswa->alamat;
        $this->email         = $siswa->email;
        $this->username      = $siswa->username;
        $this->password      = ''; // Kosongkan, user bisa memasukkan jika ingin ganti
        $this->fotoPreview   = $siswa->foto; // Path foto lama (storage)
    }

    protected function rules()
    {
        return [
            'id_kelas'      => 'required|exists:kelas,id_kelas',
            'nisn'          => 'required|string',
            'namaSiswa'     => 'required|string',
            'namaOrangTua'  => 'required|string',
            'tgl_lahir'     => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat'        => 'required|string',
            'email'         => 'required|email',
            'username'      => 'required|string',
            'password'      => 'nullable|string|min:6',
            'foto'          => 'nullable|image|max:1024',
        ];
    }

    public function updatedFoto()
    {
        // Validasi hanya atribut foto saat diupload
        $this->validateOnly('foto');
    }

    public function updateProfil()
    {
        $this->validate();

        $data = [
            'id_kelas'      => $this->id_kelas,
            'nisn'          => $this->nisn,
            'namaSiswa'     => $this->namaSiswa,
            'namaOrangTua'  => $this->namaOrangTua,
            'tgl_lahir'     => $this->tgl_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'alamat'        => $this->alamat,
            'email'         => $this->email,
            'username'      => $this->username,
        ];

        if ($this->password) {
            $data['password'] = bcrypt($this->password);
        }

        if ($this->foto) {
            // Hapus file lama jika ada
            if ($this->fotoPreview && Storage::disk('public')->exists($this->fotoPreview)) {
                Storage::disk('public')->delete($this->fotoPreview);
            }
            $data['foto'] = $this->foto->store('siswa', 'public');
        }

        // Update data berdasarkan id_akunsiswa
        AkunSiswa::where('id_akunsiswa', $this->id_akunsiswa)->update($data);

        // Segarkan fotoPreview jika ada foto baru
        if (isset($data['foto'])) {
            $this->fotoPreview = $data['foto'];
            $this->foto = null;
        }

        session()->flash('message', 'Profil berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.akun-siswa.profil', [
            'kelasList' => Kelas::all(),
        ]);
    }
}
