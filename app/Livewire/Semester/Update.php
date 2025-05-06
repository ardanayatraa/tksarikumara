<?php

namespace App\Livewire\Semester;

use Livewire\Component;
use App\Models\Semester;

class Update extends Component
{
    public $open = false;
    public $id_semester, $nama_semester, $tahun_awal, $tahun_akhir;

    protected $listeners = ['editSemester'];

    protected $rules = [
        'nama_semester' => 'required|string',
        'tahun_awal'    => 'required|integer',
        'tahun_akhir'   => 'required|integer|gte:tahun_awal',
    ];

    public function editSemester($id)
    {
        $semester = Semester::findOrFail($id);
        $this->id_semester   = $semester->id_semester;
        $this->nama_semester = $semester->nama_semester;
        $this->tahun_awal    = $semester->tahun_awal;
        $this->tahun_akhir   = $semester->tahun_akhir;
        $this->open = true;
    }

    public function update()
    {
        $this->validate();

        Semester::where('id_semester', $this->id_semester)->update([
            'nama_semester' => $this->nama_semester,
            'tahun_awal'    => $this->tahun_awal,
            'tahun_akhir'   => $this->tahun_akhir,
        ]);

        $this->reset(['open', 'id_semester', 'nama_semester', 'tahun_awal', 'tahun_akhir']);
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.semester.update');
    }
}
