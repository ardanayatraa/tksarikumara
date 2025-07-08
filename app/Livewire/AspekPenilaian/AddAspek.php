<?php

namespace App\Livewire\AspekPenilaian;

use App\Models\AspekPenilaian;
use Livewire\Component;
use Illuminate\Support\Str;

class AddAspek extends Component
{
    public $open = false;
    public $kode_aspek, $nama_aspek, $kategori;

    protected $rules = [
        'kode_aspek' => 'required|string|max:10',
        'nama_aspek' => 'required|string|max:100',
        'kategori' => 'required|string|max:50',
    ];

    public function updated($field)
    {
        if ($field === 'nama_aspek') {
            $this->generateKodeAspek();
        }
    }

    protected function generateKodeAspek()
    {
        if (!$this->nama_aspek) {
            $this->kode_aspek = '';
            return;
        }

        // Ambil kata pertama dari nama aspek
        $first = explode(' ', trim($this->nama_aspek))[0];
        $singkatan = strtoupper(Str::substr($first, 0, 3));
        $tahun = now()->year;

        $this->kode_aspek = $singkatan . $tahun;
    }

    public function save()
    {
        $this->validate();

        AspekPenilaian::create([
            'kode_aspek' => $this->kode_aspek,
            'nama_aspek' => $this->nama_aspek,
            'kategori' => $this->kategori,
        ]);

        $this->reset(['open', 'kode_aspek', 'nama_aspek', 'kategori']);
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.aspek-penilaian.add-aspek');
    }
}
