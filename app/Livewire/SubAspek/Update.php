<?php

namespace App\Livewire\SubAspek;

use Livewire\Component;
use App\Models\AspekPenilaian;
use App\Models\SubAspek;

class Update extends Component
{
    public $open = false;
    public $id;
    public $aspek_id;
    public $kode_sub_aspek;
    public $nama_sub_aspek;
    public $deskripsi;

    public $aspeks = [];

    protected $listeners = ['editSubAspek'];

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

    public function editSubAspek($id)
    {
        $subAspek = SubAspek::with('aspekPenilaian')->findOrFail($id);

        $this->id = $subAspek->id_sub_aspek;
        $this->aspek_id = $subAspek->aspek_id;
        $this->kode_sub_aspek = $subAspek->kode_sub_aspek;
        $this->nama_sub_aspek = $subAspek->nama_sub_aspek;
        $this->deskripsi = $subAspek->deskripsi;

        $this->open = true;
    }

    public function update()
    {
        $this->validate();

        // Validasi unique combination (exclude current record)
        $exists = SubAspek::where('aspek_id', $this->aspek_id)
            ->where('kode_sub_aspek', $this->kode_sub_aspek)
            ->where('id_sub_aspek', '!=', $this->id)
            ->exists();

        if ($exists) {
            $this->addError('kode_sub_aspek', 'Kode sub aspek sudah digunakan untuk aspek ini.');
            return;
        }

        SubAspek::where('id_sub_aspek', $this->id)->update([
            'aspek_id' => $this->aspek_id,
            'kode_sub_aspek' => $this->kode_sub_aspek,
            'nama_sub_aspek' => $this->nama_sub_aspek,
            'deskripsi' => $this->deskripsi,
        ]);

        $this->reset(['open', 'id', 'aspek_id', 'kode_sub_aspek', 'nama_sub_aspek', 'deskripsi']);
        $this->dispatch('refreshDatatable');

        session()->flash('message', 'Sub aspek berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.sub-aspek.update');
    }
}
