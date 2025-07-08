<?php

namespace App\Livewire\AspekPenilaian;

use Livewire\Component;
use App\Models\AspekPenilaian;
use App\Models\IndikatorAspek;
use Illuminate\Support\Str;

class Add extends Component
{
    public $open = false;
    public $aspek_id = null;
    public $rentang;
    public $kode_indikator;
    public $nama_indikator;
    public $bobot;

    public $aspeks = [];
    public $suggestedCodes = [];
    public $ranges = [
        '2-3' => '2–3 Tahun',
        '3-4' => '3–4 Tahun',
        '4-5' => '4–5 Tahun',
        '5-6' => '5–6 Tahun',
    ];

    protected function rules()
    {
        return [
            'aspek_id'        => 'required|exists:aspek_penilaian,id_aspek',
            'rentang'         => 'required|in:2-3,3-4,4-5,5-6',
            'kode_indikator'  => 'required|string|unique:indikator_aspek,kode_indikator',
            'nama_indikator'  => 'required|string',
            'bobot'           => 'required|integer|min:1|max:10',
        ];
    }

    public function mount()
    {
        $this->aspeks = AspekPenilaian::orderBy('kode_aspek')->get();
    }

    public function updatedAspekId($value)
    {
        $this->kode_indikator = null;
        $this->suggestedCodes = [];

        if ($value) {
            $parent = AspekPenilaian::findOrFail($value);
            $prefix = $parent->kode_aspek . '.';

            $existing = IndikatorAspek::where('aspek_id', $value)
                ->pluck('kode_indikator')
                ->map(fn($code) => Str::after($code, $prefix))
                ->toArray();

            $letters = range('A', 'Z');
            $available = array_diff($letters, $existing);

            $this->suggestedCodes = array_map(fn($l) => $prefix . $l, $available);
        }
    }

    public function save()
    {
        $this->validate();

        [$min, $max] = explode('-', $this->rentang);

        IndikatorAspek::create([
            'aspek_id'       => $this->aspek_id,
            'kode_indikator' => $this->kode_indikator,
            'nama_indikator' => $this->nama_indikator,
            'min_umur'       => $min,
            'max_umur'       => $max,
            'bobot'          => $this->bobot,
        ]);

        $this->reset(['open','aspek_id','rentang','kode_indikator','nama_indikator','bobot','suggestedCodes']);
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.aspek-penilaian.add');
    }
}
