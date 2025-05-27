<?php

namespace App\Livewire\AspekPenilaian;

use Livewire\Component;
use App\Models\AspekPenilaian;

class Update extends Component
{
    public $open = false;
    public $id_aspek;
    public $rentang;
    public $parent_id;
    public $kode_aspek;
    public $nama_aspek;
    public $kategori;

    public $ranges = [
        '2-3' => '2–3 Tahun',
        '3-4' => '3–4 Tahun',
        '4-5' => '4–5 Tahun',
        '5-6' => '5–6 Tahun',
    ];

    public $parents = [];

    protected $listeners = ['editAspekPenilaian'];

    protected function rules()
    {
        return [
            'rentang'    => 'required|in:2-3,3-4,4-5,5-6',
            'parent_id'  => 'nullable|exists:aspek_penilaian,id_aspek',
            'kode_aspek' => 'required|string|unique:aspek_penilaian,kode_aspek,'.$this->id_aspek.',id_aspek',
            'nama_aspek' => 'required|string',
            'kategori'   => 'required|string',
        ];
    }

    public function mount()
    {
        $this->parents = [];
    }

    public function editAspekPenilaian($id)
    {
        $asp = AspekPenilaian::findOrFail($id);
        $this->id_aspek   = $asp->id_aspek;
        $this->rentang    = $asp->min_umur.'-'.$asp->max_umur;
        $this->parent_id  = $asp->parent_id;
        $this->kode_aspek = $asp->kode_aspek;
        $this->nama_aspek = $asp->nama_aspek;
        $this->kategori   = $asp->kategori;

        $this->loadParents();
        $this->open = true;
    }

    public function updatedRentang($value)
    {
        [$min, $max] = explode('-', $value);
        $this->parent_id = null;
        $this->parents = AspekPenilaian::whereNull('parent_id')
            ->where('min_umur', $min)
            ->where('max_umur', $max)
            ->orderBy('kode_aspek')
            ->get();
    }

    protected function loadParents()
    {
        if ($this->rentang) {
            [$min, $max] = explode('-', $this->rentang);
            $this->parents = AspekPenilaian::whereNull('parent_id')
                ->where('min_umur', $min)
                ->where('max_umur', $max)
                ->orderBy('kode_aspek')
                ->get();
        } else {
            $this->parents = [];
        }
    }

    public function update()
    {
        $this->validate();
        [$min, $max] = explode('-', $this->rentang);

        AspekPenilaian::where('id_aspek', $this->id_aspek)->update([
            'parent_id'  => $this->parent_id,
            'kode_aspek' => $this->kode_aspek,
            'nama_aspek' => $this->nama_aspek,
            'kategori'   => $this->kategori,
            'min_umur'   => $min,
            'max_umur'   => $max,
        ]);

        $this->reset(['open','id_aspek','rentang','parent_id','kode_aspek','nama_aspek','kategori','parents']);
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.aspek-penilaian.update');
    }
}
