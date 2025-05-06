<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Kelas;

class KelasTable extends DataTableComponent
{
    protected $model = Kelas::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id_kelas');
    }

    public function columns(): array
    {
        return [
            Column::make('Id Kelas', 'id_kelas')
                ->sortable(),
            Column::make('Nama Kelas', 'namaKelas')
                ->sortable(),
            Column::make('Tahun Ajaran', 'tahunAjaran')
                ->sortable(),
            Column::make('Jumlah Siswa', 'jumlahSiswa')
                ->sortable(),
            Column::make('Created At', 'created_at')
                ->sortable(),
            Column::make('Updated At', 'updated_at')
                ->sortable(),

            Column::make('Actions')
                ->label(fn($row) => view('components.table-action', [
                    'id' => $row->id_kelas,

                ]))
                ->html(),
        ];
    }

    public function edit($id): void
    {
        $this->dispatch('editKelas', $id);
    }

    public function delete($id): void
    {
        $this->dispatch('deleteKelas', $id);
    }
}
