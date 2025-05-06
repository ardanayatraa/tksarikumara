<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\AspekPenilaian;

class AspekPenilaianTable extends DataTableComponent
{
    protected $model = AspekPenilaian::class;

    public function configure(): void
    {
        // gunakan primary key yang sesuai dengan model
        $this->setPrimaryKey('id_aspek');
    }

    public function columns(): array
    {
        return [
            Column::make('Id Aspek', 'id_aspek')
                ->sortable(),

            Column::make('Kode Aspek', 'kode_aspek')
                ->sortable(),

            Column::make('Nama Aspek', 'nama_aspek')
                ->sortable(),

            Column::make('Kategori', 'kategori')
                ->sortable(),



            Column::make('Actions')
                ->label(fn($row) => view('components.table-action', [
                    'id'          => $row->id_aspek,

                ]))
                ->html(),
        ];
    }

    public function edit($id): void
    {
        $this->dispatch('editAspekPenilaian', $id);
    }

    public function delete($id): void
    {
        $this->dispatch('deleteAspekPenilaian', $id);
    }
}
