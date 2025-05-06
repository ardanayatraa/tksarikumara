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
            Column::make("Nama Kepala Sekolah", "namaKepalaSekolah")
                ->sortable(),
            Column::make("Nip", "nip")
                ->sortable(),
            Column::make("Email", "email")
                ->sortable(),
            Column::make("No tlp", "notlp")
                ->sortable(),
            Column::make("Username", "username")
                ->sortable(),

                Column::make('Actions')
                ->label(fn($row) => view('components.table-action', [
                    'id'          => $row->id_kepalasekolah,

                ]))
                ->html(),
        ];
    }

    public function edit($id): void
    {
        $this->dispatch('editKepsek', $id);
    }

    public function delete($id): void
    {
        $this->dispatch('deleteKepsek', $id);
    }
}
