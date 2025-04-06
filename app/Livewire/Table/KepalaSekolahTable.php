<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\KepalaSekolah;

class KepalaSekolahTable extends DataTableComponent
{
    protected $model = KepalaSekolah::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id_kepalasekolah');
    }

    public function columns(): array
    {
        return [
            Column::make("Id kepalasekolah", "id_kepalasekolah")
                ->sortable(),
            Column::make("NamaKepalaSekolah", "namaKepalaSekolah")
                ->sortable(),
            Column::make("Nip", "nip")
                ->sortable(),
            Column::make("Email", "email")
                ->sortable(),
            Column::make("Notlp", "notlp")
                ->sortable(),
            Column::make("Username", "username")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
