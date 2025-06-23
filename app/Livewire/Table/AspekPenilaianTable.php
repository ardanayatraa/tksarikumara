<?php

namespace App\Livewire\Table;

use App\Models\IndikatorAspek;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class AspekPenilaianTable extends DataTableComponent
{
    protected $model = IndikatorAspek::class;

    public function configure(): void
    {
        // primary key sesuai migration: $table->id()
        $this->setPrimaryKey('id');
    }

    public function builder(): Builder
    {
        // eager-load relasi ke aspek utama
        return IndikatorAspek::query()
            ->with('aspek');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable(),

            Column::make('Kode Aspek', 'aspek.kode_aspek')
                ->sortable(),
            Column::make('Aspek Penilaian', 'aspek.nama_aspek')
                ->sortable(),

            Column::make('Kode Indikator', 'kode_indikator')
                ->sortable(),

            Column::make('Nama Indikator', 'nama_indikator')
                ->sortable(),

            Column::make('Min Umur (Tahun)', 'min_umur'),
            Column::make('Max Umur (Tahun)', 'max_umur'),

            Column::make('Actions')
                ->label(fn($row) => view('components.table-action', [
                    'id' => $row->id,
                ]))
                ->html(),
        ];
    }

    public function edit($id): void
    {
        $this->dispatch('editIndikatorAspek', $id);
    }

    public function delete($id): void
    {
        $this->dispatch('deleteIndikatorAspek', $id);
    }
}
