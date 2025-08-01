<?php

namespace App\Livewire\SubAspek;

use Livewire\Component;
use App\Models\AspekPenilaian;
use App\Models\SubAspek;

class Create extends Component
{
    public $open = false;
    public $aspek_id;
    public $kode_sub_aspek;
    public $nama_sub_aspek;
    public $deskripsi;

    public $aspeks = [];

    protected function rules()
    {
        return [
            'aspek_id' => 'required|exists:aspek_penilaian,id_aspek',
            'kode_sub_aspek' => 'required|string|max:10',
            'nama_sub_aspek' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ];
    }

    public function mount()
    {
        $this->aspeks = AspekPenilaian::where('has_sub_aspek', true)
            ->where('is_active', true)
            ->orderBy('kode_aspek')
            ->get();
    }

    public function save()
    {
        $this->validate();

        // Validasi unique combination
        $exists = SubAspek::where('aspek_id', $this->aspek_id)
            ->where('kode_sub_aspek', $this->kode_sub_aspek)
            ->exists();

        if ($exists) {
            $this->addError('kode_sub_aspek', 'Kode sub aspek sudah digunakan untuk aspek ini.');
            return;
        }

        SubAspek::create([
            'aspek_id' => $this->aspek_id,
            'kode_sub_aspek' => $this->kode_sub_aspek,
            'nama_sub_aspek' => $this->nama_sub_aspek,
            'deskripsi' => $this->deskripsi,
            'is_active' => true,
        ]);

        $this->reset(['open', 'aspek_id', 'kode_sub_aspek', 'nama_sub_aspek', 'deskripsi']);
        $this->dispatch('refreshDatatable');

        session()->flash('message', 'Sub aspek berhasil ditambahkan!');
    }

    public function render()
    {
        return view('livewire.sub-aspek.create');
    }
}
