<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\AkunSiswa;

class AkunSiswaTable extends DataTableComponent
{
    protected $model = AkunSiswa::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id_akunsiswa');
    }

    public function columns(): array
    {
        return [
            Column::make("Id akunsiswa", "id_akunsiswa")
                ->sortable(),
            Column::make("Id kelas", "id_kelas")
                ->sortable(),
            Column::make("Nisn", "nisn")
                ->sortable(),
            Column::make("NamaSiswa", "namaSiswa")
                ->sortable(),
            Column::make("Tgl lahir", "tgl_lahir")
                ->sortable(),
            Column::make("Jenis kelamin", "jenis_kelamin")
                ->sortable(),
            Column::make("Alamat", "alamat")
                ->sortable(),
            Column::make("Email", "email")
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
