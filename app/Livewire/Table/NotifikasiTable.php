<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Notifikasi;

class NotifikasiTable extends DataTableComponent
{
    protected $model = Notifikasi::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id_notifikasi');
    }

    public function columns(): array
    {
        return [
            Column::make("Id notifikasi", "id_notifikasi")
                ->sortable(),
            Column::make("Id akunsiswa", "id_akunsiswa")
                ->sortable(),
            Column::make("Id penilaian", "id_penilaian")
                ->sortable(),
            Column::make("Id guru", "id_guru")
                ->sortable(),
            Column::make("Tgl penilaian", "tgl_penilaian")
                ->sortable(),
            Column::make("Status pengiriman", "status_pengiriman")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
