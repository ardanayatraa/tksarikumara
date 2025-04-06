<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Guru;

class GuruTable extends DataTableComponent
{
    protected $model = Guru::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id_guru');
    }

    public function columns(): array
    {
        return [
            Column::make("Id guru", "id_guru")
                ->sortable(),
            Column::make("NamaGuru", "namaGuru")
                ->sortable(),
            Column::make("Nip", "nip")
                ->sortable(),
            Column::make("Username", "username")
                ->sortable(),
            Column::make("Email", "email")
                ->sortable(),
            Column::make("Jenis kelamin", "jenis_kelamin")
                ->sortable(),
            Column::make("Notlp", "notlp")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
