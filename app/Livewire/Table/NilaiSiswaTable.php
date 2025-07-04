<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\NilaiSiswa;

class NilaiSiswaTable extends DataTableComponent
{
    protected $model = NilaiSiswa::class;

    public function configure(): void
    {
        // Gunakan primary key sesuai model
        $this->setPrimaryKey('id_nilai');
    }

    public function columns(): array
    {
        return [
            Column::make('Id Nilai', 'id_nilai')
                ->sortable(),

            Column::make('Penilaian', 'penilaian.tgl_penilaian')
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

            Column::make('Nilai', 'nilai')
                ->sortable(),

            Column::make('Skor', 'skor')
                ->sortable(),

            // Column::make('Actions')
            //     ->label(fn($row) => view('components.table-action', [
            //         'id'          => $row->id_nilai,
            //         'editEvent'   => 'editNilaiSiswa',
            //         'deleteEvent' => 'deleteNilaiSiswa',
            //     ]))
            //     ->html(),
        ];
    }

    public function edit($id): void
    {
        $this->dispatch('editNilaiSiswa', $id);
    }

    public function delete($id): void
    {
        $this->dispatch('delete', $id);
    }
}
