<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Penilaian;

class PenilaianTable extends DataTableComponent
{
    protected $model = Penilaian::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id_penilaian');
    }

    public function columns(): array
    {
        return [
            Column::make("Id penilaian", "id_penilaian")
                ->sortable(),
            Column::make("Id akunsiswa", "id_akunsiswa")
                ->sortable(),
            Column::make("Id guru", "id_guru")
                ->sortable(),
            Column::make("Tgl penilaian", "tgl_penilaian")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
