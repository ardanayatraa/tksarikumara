<?php

// File: app/Livewire/Indikator/Create.php
namespace App\Livewire\Indikator;

use Livewire\Component;
use App\Models\AspekPenilaian;
use App\Models\SubAspek;
use App\Models\Indikator;
use Illuminate\Support\Str;

class Create extends Component
{
    public $open = false;
    public $aspek_id = null;
    public $sub_aspek_id = null;
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

    public function updatedAspekId($value)
    {
        $this->sub_aspek_id = null;
        $this->kode_indikator = null;
        $this->suggestedCodes = [];
        $this->subAspeks = [];

        if ($value) {
            $aspek = AspekPenilaian::findOrFail($value);

            if ($aspek->has_sub_aspek) {
                $this->subAspeks = SubAspek::where('aspek_id', $value)
                    ->where('is_active', true)
                    ->orderBy('kode_sub_aspek')
                    ->get();
            } else {
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

    protected function generateSuggestedCodes($aspekId, $subAspekId = null)
    {
        if (!$this->kelompok_usia) return;

        $aspek = AspekPenilaian::findOrFail($aspekId);
        $prefix = $aspek->kode_aspek . '.';

        if ($subAspekId) {
            $subAspek = SubAspek::findOrFail($subAspekId);
            $prefix .= $subAspek->kode_sub_aspek . '.';
        }

        $existing = Indikator::where('aspek_id', $aspekId)
            ->where('sub_aspek_id', $subAspekId)
            ->where('kelompok_usia', $this->kelompok_usia)
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
    }

    public function save()
    {
        $this->validate();

        // Validasi unique
        $exists = Indikator::where('aspek_id', $this->aspek_id)
            ->where('sub_aspek_id', $this->sub_aspek_id)
            ->where('kode_indikator', $this->kode_indikator)
            ->where('kelompok_usia', $this->kelompok_usia)
            ->exists();

        if ($exists) {
            $this->addError('kode_indikator', 'Kode indikator sudah digunakan untuk aspek dan kelompok usia ini.');
            return;
        }

        Indikator::create([
            'aspek_id'              => $this->aspek_id,
            'sub_aspek_id'          => $this->sub_aspek_id,
            'kode_indikator'        => $this->kode_indikator,
            'deskripsi_indikator'   => $this->deskripsi_indikator,
            'kelompok_usia'         => $this->kelompok_usia,
            'is_active'             => true,
        ]);

        $this->reset(['open','aspek_id','sub_aspek_id','kelompok_usia','kode_indikator','deskripsi_indikator','suggestedCodes','subAspeks']);
        $this->dispatch('refreshDatatable');

        session()->flash('message', 'Indikator berhasil ditambahkan!');
    }

    public function render()
    {
        return view('livewire.indikator.create');
    }
}
