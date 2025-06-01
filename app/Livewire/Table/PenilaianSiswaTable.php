<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\AkunSiswa;
use Illuminate\Support\Facades\Auth;
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

                Column::make("Kelas", "kelas.namaKelas")
                ->sortable(),


              LinkColumn::make('Action')
                ->title(fn($row) => 'Lihat Nilai')
                ->location(function($row) {
                    if (Auth::guard('kepsek')->check()) {
                        return route('kepsek.penilaian.detail', $row);
                    }
                    // Default guru
                    return route('guru.penilaian.detail', $row);
                })
                ->attributes(fn($row) => [
                    'class' => 'text-blue-600 hover:underline font-semibold',
                ]),


        ];
    }
}
