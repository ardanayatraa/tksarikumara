<?php

namespace App\Livewire\AspekPenilaian;

use Livewire\Component;
use App\Models\AspekPenilaian;
use Illuminate\Support\Str;

class Add extends Component
{
    public $open = false;
    public $rentang;
    public $parent_id = null;
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
    public $suggestedCodes = [];  // kode child yang tersedia

    protected function rules()
    {
        return [
            'rentang'    => 'required|in:2-3,3-4,4-5,5-6',
            'parent_id'  => 'nullable|exists:aspek_penilaian,id_aspek',
            'kode_aspek' => 'required|string',
            'nama_aspek' => 'required|string',
            'kategori'   => 'required|string',
        ];
    }

    public function mount()
    {
        $this->parents = [];
        $this->suggestedCodes = [];
    }

    public function updatedRentang($value)
    {
        [$min, $max] = explode('-', $value);
        $this->parent_id = null;
        $this->suggestedCodes = [];
        $this->parents = AspekPenilaian::whereNull('parent_id')
            ->where('min_umur', $min)
            ->where('max_umur', $max)
            ->orderBy('kode_aspek')
            ->get();
    }

    public function updatedParentId($value)
    {
        if ($value) {
            // ambil kode parent
            $parent = AspekPenilaian::findOrFail($value);
            $prefix = $parent->kode_aspek . '.';

            // cari existing child suffix
            $existing = AspekPenilaian::where('parent_id', $value)
                        ->pluck('kode_aspek')
                        ->map(fn($ka) => Str::after($ka, $prefix))
                        ->toArray();

            // semua huruf A–Z kecuali yang sudah ada
            $letters = range('A','Z');
            $available = array_diff($letters, $existing);

            // bentuk suggestedCodes
            $this->suggestedCodes = array_map(fn($l) => $prefix . $l, $available);
        } else {
            $this->suggestedCodes = [];
        }

        // bersihkan kode_aspek lama
        $this->kode_aspek = null;
    }

    public function save()
    {
        $this->validate();

        [$min, $max] = explode('-', $this->rentang);

        AspekPenilaian::create([
            'parent_id'  => $this->parent_id,
            'kode_aspek' => $this->kode_aspek,
            'nama_aspek' => $this->nama_aspek,
            'kategori'   => $this->kategori,
            'min_umur'   => $min,
            'max_umur'   => $max,
        ]);

        $this->reset(['open','rentang','parent_id','kode_aspek','nama_aspek','kategori','parents','suggestedCodes']);
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.aspek-penilaian.add');
    }
}
