<?php

namespace App\Livewire\Table;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\NilaiSiswa;
use Illuminate\Database\Eloquent\Builder;
class NilaiSiswaTable extends DataTableComponent
{
    protected $model = NilaiSiswa::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id_nilai');
    }

    /**
     * Override builder agar hanya menampilkan nilai siswa
     * yang sedang login (guard 'siswa').
     */
    public function builder(): Builder
    {
        $siswaId = Auth::guard('siswa')->id();

        return NilaiSiswa::query()
            ->whereHas('penilaian', fn($q) =>
                $q->where('id_akunsiswa', $siswaId)
            )
            ->with(['penilaian', 'indikator.aspek']);
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id_nilai')->sortable(),

            Column::make('Tanggal', 'penilaian.tgl_penilaian')
                ->sortable()
                ->searchable(),

            Column::make('Kode Aspek', 'indikator.aspek.kode_aspek')
                ->sortable()
                ->searchable(),

            Column::make('Aspek Penilaian', 'indikator.aspek.nama_aspek')
                ->sortable()
                ->searchable(),

            Column::make('Kode Indikator', 'indikator.kode_indikator')
                ->sortable()
                ->searchable(),

            Column::make('Indikator', 'indikator.nama_indikator')
                ->sortable()
                ->searchable(),

            Column::make('Nilai', 'nilai')->sortable(),

            Column::make('Skor', 'skor')->sortable(),
        ];
    }

    public function edit($id): void
    {
        $this->dispatch('editNilaiSiswa', $id);
    }

    public function delete($id): void
    {
        $this->dispatch('deleteNilaiSiswa', $id);
    }
}
