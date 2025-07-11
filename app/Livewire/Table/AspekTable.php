<?php

namespace App\Livewire\Table;

use App\Models\AspekPenilaian;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class AspekTable extends DataTableComponent
{
    protected $model = AspekPenilaian::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id_aspek');
        $this->setDefaultSort('id_aspek', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id_aspek')->sortable(),
            Column::make('Kode Aspek', 'kode_aspek')->searchable()->sortable(),
            Column::make('Nama Aspek', 'nama_aspek')->searchable()->sortable(),
            Column::make('Kategori', 'kategori')->searchable()->sortable(),

            Column::make('Aksi')
                ->label(fn ($row) => view('components.table-action', [
                    'id' => $row->id_aspek,
                    'editEvent' => 'editAspek',
                    'deleteEvent' => 'deleteAspek',
                ]))
                ->html(),
        ];
    }

    public function edit($id): void
    {
        $this->dispatch('editAspek', $id);
    }

    public function delete($id): void
    {
        $this->dispatch('deleteAspek', $id);
    }
}
