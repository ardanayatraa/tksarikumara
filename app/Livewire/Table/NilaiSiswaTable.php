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
        $this->setPrimaryKey('id_nilai');
    }

    public function columns(): array
    {
        return [
            Column::make("Id nilai", "id_nilai")
                ->sortable(),
            Column::make("Id penilaian", "id_penilaian")
                ->sortable(),
            Column::make("Aspek penilaian", "aspek_penilaian")
                ->sortable(),
            Column::make("Kategori", "kategori")
                ->sortable(),
            Column::make("Skor", "skor")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
