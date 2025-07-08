<?php

namespace App\Livewire\AspekPenilaian;

use Livewire\Component;
use App\Models\AspekPenilaian;
use App\Models\IndikatorAspek;
use Illuminate\Support\Str;

class Update extends Component
{
    public $open = false;
    public $id;
    public $aspek_id;
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

    protected $listeners = ['editIndikatorAspek'];

    protected function rules()
    {
        return [
            'aspek_id'        => 'required|exists:aspek_penilaian,id_aspek',
            'rentang'         => 'required|in:2-3,3-4,4-5,5-6',
            'kode_indikator'  => 'required|string|unique:indikator_aspek,kode_indikator,' . $this->id,
            'nama_indikator'  => 'required|string',
            'bobot'           => 'required|integer|min:1|max:10',
        ];
    }

    public function mount()
    {
        $this->aspeks = AspekPenilaian::orderBy('kode_aspek')->get();
    }

    public function editIndikatorAspek($id)
    {
        $i = IndikatorAspek::findOrFail($id);
        $this->id             = $i->id;
        $this->aspek_id       = $i->aspek_id;
        $this->rentang        = $i->min_umur . '-' . $i->max_umur;
        $this->kode_indikator = $i->kode_indikator;
        $this->nama_indikator = $i->nama_indikator;
        $this->bobot          = $i->bobot;

        $this->generateSuggestedCodes($this->aspek_id);

        $this->open = true;
    }

    public function updatedAspekId($value)
    {
        $this->generateSuggestedCodes($value);
    }

    protected function generateSuggestedCodes($aspekId)
    {
        $this->suggestedCodes = [];

        if ($aspekId) {
            $aspek = AspekPenilaian::find($aspekId);
            if (!$aspek) return;

            $prefix = $aspek->kode_aspek . '.';
            $existing = IndikatorAspek::where('aspek_id', $aspekId)
                ->pluck('kode_indikator')
                ->map(fn($c) => Str::after($c, $prefix))
                ->toArray();

            $letters = range('A', 'Z');
            $available = array_diff($letters, $existing);
            $this->suggestedCodes = array_map(fn($l) => $prefix . $l, $available);

            if (!$this->kode_indikator) {
                $this->kode_indikator = $this->suggestedCodes[0] ?? null;
            }
        }
    }

    public function update()
    {
        $this->validate();
        [$min, $max] = explode('-', $this->rentang);

        IndikatorAspek::where('id', $this->id)->update([
            'aspek_id'       => $this->aspek_id,
            'kode_indikator' => $this->kode_indikator,
            'nama_indikator' => $this->nama_indikator,
            'min_umur'       => $min,
            'max_umur'       => $max,
            'bobot'          => $this->bobot,
        ]);

        $this->reset([
            'open', 'id', 'aspek_id', 'rentang',
            'kode_indikator', 'nama_indikator',
            'bobot', 'suggestedCodes'
        ]);

        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.aspek-penilaian.update');
    }
}
