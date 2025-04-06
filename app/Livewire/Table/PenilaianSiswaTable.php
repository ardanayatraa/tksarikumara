<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\AkunSiswa;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class PenilaianSiswaTable extends DataTableComponent
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

                LinkColumn::make('Action')
                ->title(fn($row) => 'Lihat Nilai')
                ->location(fn($row) => route('guru.penilaian.detail', $row))
                ->attributes(fn($row) => [
                    'class' => 'text-blue-600 hover:underline font-semibold',
                ]),


        ];
    }
}
