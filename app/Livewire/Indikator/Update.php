<?php

// File: app/Livewire/Indikator/Update.php
namespace App\Livewire\Indikator;

use Livewire\Component;
use App\Models\AspekPenilaian;
use App\Models\SubAspek;
use App\Models\Indikator;
use Illuminate\Support\Str;

class Update extends Component
{
    public $open = false;
    public $id;
    public $aspek_id;
    public $sub_aspek_id;
    public $kelompok_usia;
    public $kode_indikator;
    public $deskripsi_indikator;

    public $aspeks = [];
    public $subAspeks = [];
    public $suggestedCodes = [];
    public $kelompokUsiaOptions = [
        '2-3_tahun' => '2–3 Tahun',
        '3-4_tahun' => '3–4 Tahun',
        '4-5_tahun' => '4–5 Tahun',
        '5-6_tahun' => '5–6 Tahun',
    ];

    protected $listeners = ['editIndikator'];

    protected function rules()
    {
        return [
            'aspek_id'              => 'required|exists:aspek_penilaian,id_aspek',
            'sub_aspek_id'          => 'nullable|exists:sub_aspek,id_sub_aspek',
            'kelompok_usia'         => 'required|in:2-3_tahun,3-4_tahun,4-5_tahun,5-6_tahun',
            'kode_indikator'        => 'required|string',
            'deskripsi_indikator'   => 'required|string',
        ];
    }

    public function mount()
    {
        $this->aspeks = AspekPenilaian::where('is_active', true)->orderBy('kode_aspek')->get();
    }

    public function editIndikator($id)
    {
        $indikator = Indikator::with(['aspekPenilaian', 'subAspek'])->findOrFail($id);

        $this->id                   = $indikator->id_indikator;
        $this->aspek_id             = $indikator->aspek_id;
        $this->sub_aspek_id         = $indikator->sub_aspek_id;
        $this->kelompok_usia        = $indikator->kelompok_usia;
        $this->kode_indikator       = $indikator->kode_indikator;
        $this->deskripsi_indikator  = $indikator->deskripsi_indikator;

        $this->loadSubAspeks($this->aspek_id);
        $this->generateSuggestedCodes($this->aspek_id, $this->sub_aspek_id);

        $this->open = true;
    }

    public function updatedAspekId($value)
    {
        $this->sub_aspek_id = null;
        $this->kode_indikator = null;
        $this->suggestedCodes = [];

        $this->loadSubAspeks($value);

        if ($value) {
            $aspek = AspekPenilaian::findOrFail($value);
            if (!$aspek->has_sub_aspek) {
                $this->generateSuggestedCodes($value, null);
            }
        }
    }

    public function updatedSubAspekId($value)
    {
        $this->kode_indikator = null;
        $this->suggestedCodes = [];

        if ($this->aspek_id) {
            $this->generateSuggestedCodes($this->aspek_id, $value);
        }
    }

    public function updatedKelompokUsia($value)
    {
        if ($this->aspek_id) {
            $this->generateSuggestedCodes($this->aspek_id, $this->sub_aspek_id);
        }
    }

    protected function loadSubAspeks($aspekId)
    {
        $this->subAspeks = [];

        if ($aspekId) {
            $aspek = AspekPenilaian::findOrFail($aspekId);

            if ($aspek->has_sub_aspek) {
                $this->subAspeks = SubAspek::where('aspek_id', $aspekId)
                    ->where('is_active', true)
                    ->orderBy('kode_sub_aspek')
                    ->get();
            }
        }
    }

    protected function generateSuggestedCodes($aspekId, $subAspekId = null)
    {
        $this->suggestedCodes = [];

        if (!$aspekId || !$this->kelompok_usia) return;

        $aspek = AspekPenilaian::findOrFail($aspekId);
        $prefix = $aspek->kode_aspek . '.';

        if ($subAspekId) {
            $subAspek = SubAspek::findOrFail($subAspekId);
            $prefix .= $subAspek->kode_sub_aspek . '.';
        }

        $existing = Indikator::where('aspek_id', $aspekId)
            ->where('sub_aspek_id', $subAspekId)
            ->where('kelompok_usia', $this->kelompok_usia)
            ->where('id_indikator', '!=', $this->id)
            ->pluck('kode_indikator')
            ->toArray();

        $numbers = range(1, 20);
        $existingNumbers = [];

        foreach ($existing as $code) {
            $number = (int) Str::after($code, $prefix);
            if ($number > 0) {
                $existingNumbers[] = $number;
            }
        }

        $available = array_diff($numbers, $existingNumbers);
        $this->suggestedCodes = array_map(fn($n) => $prefix . $n, array_slice($available, 0, 5));

        if ($this->kode_indikator && !in_array($this->kode_indikator, $this->suggestedCodes)) {
            array_unshift($this->suggestedCodes, $this->kode_indikator);
        }
    }

    public function update()
    {
        $this->validate();

        $exists = Indikator::where('aspek_id', $this->aspek_id)
            ->where('sub_aspek_id', $this->sub_aspek_id)
            ->where('kode_indikator', $this->kode_indikator)
            ->where('kelompok_usia', $this->kelompok_usia)
            ->where('id_indikator', '!=', $this->id)
            ->exists();

        if ($exists) {
            $this->addError('kode_indikator', 'Kode indikator sudah digunakan untuk aspek dan kelompok usia ini.');
            return;
        }

        Indikator::where('id_indikator', $this->id)->update([
            'aspek_id'              => $this->aspek_id,
            'sub_aspek_id'          => $this->sub_aspek_id,
            'kode_indikator'        => $this->kode_indikator,
            'deskripsi_indikator'   => $this->deskripsi_indikator,
            'kelompok_usia'         => $this->kelompok_usia,
        ]);

        $this->reset([
            'open', 'id', 'aspek_id', 'sub_aspek_id', 'kelompok_usia',
            'kode_indikator', 'deskripsi_indikator', 'suggestedCodes', 'subAspeks'
        ]);

        $this->dispatch('refreshDatatable');

        session()->flash('message', 'Indikator berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.indikator.update');
    }
}
