<?php

namespace App\Livewire\Table;

use App\Models\SubAspek;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class SubAspekTable extends DataTableComponent
{
    protected $model = SubAspek::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id_sub_aspek');
        $this->setDefaultSort('id_sub_aspek', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id_sub_aspek')->sortable(),
            Column::make('Aspek', 'aspekPenilaian.nama_aspek')
                ->searchable()->sortable(),
            Column::make('Kode Sub Aspek', 'kode_sub_aspek')->searchable()->sortable(),
            Column::make('Nama Sub Aspek', 'nama_sub_aspek')->searchable()->sortable(),
            BooleanColumn::make('Status', 'is_active'),
            Column::make('Aksi')
                ->label(fn ($row) => view('components.table-action', [
                    'id' => $row->id_sub_aspek,
                    'editEvent' => 'editSubAspek',
                    'deleteEvent' => 'deleteSubAspek',
                ]))
                ->html(),
        ];
    }
}
