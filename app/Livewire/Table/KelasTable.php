<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Kelas;

class KelasTable extends DatatableComponent
{
    protected $model = Kelas::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id_kelas');
    }

    public function columns(): array
    {
        return [
            Column::make("Id kelas", "id_kelas")
                ->sortable(),
            Column::make("NamaKelas", "namaKelas")
                ->sortable(),
            Column::make("TahunAjaran", "tahunAjaran")
                ->sortable(),
            Column::make("JumlahSiswa", "jumlahSiswa")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
