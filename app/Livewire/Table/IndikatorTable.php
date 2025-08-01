<?php

// File: app/Livewire/Table/IndikatorTable.php
namespace App\Livewire\Table;

use App\Models\Indikator;
use App\Models\AspekPenilaian;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class IndikatorTable extends DataTableComponent
{
    protected $model = Indikator::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id_indikator');
        $this->setDefaultSort('aspek_id', 'asc');
        $this->setSearchEnabled();
        $this->setFiltersEnabled();
        $this->setPerPageAccepted([10, 25, 50]);
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id_indikator')
                ->sortable()
                ->searchable(),


            Column::make('Kode Aspek', 'aspekPenilaian.kode_aspek')
                ->sortable()
                ->searchable(),

                   Column::make('Kode Sub Aspek', 'subAspek.kode_sub_aspek')

                ->sortable(),

            Column::make('Kode Indikator', 'kode_indikator')
                ->sortable()
                ->searchable(),


            Column::make('Aspek', 'aspekPenilaian.nama_aspek')
                ->sortable()
                ->searchable(),

            Column::make('Sub Aspek', 'subAspek.nama_sub_aspek')

                ->sortable(),

            Column::make('Deskripsi', 'deskripsi_indikator')
                ->searchable(),

            Column::make('Kelompok Usia', 'kelompok_usia')

                ->sortable(),

                  BooleanColumn::make('Status', 'is_active'),

            Column::make('Aksi')
                ->label(fn ($row, Column $column) => view('components.indikator-action', [
                    'id' => $row->id_indikator,
                ]))
                ->html(),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Aspek', 'aspek_id')
                ->options([
                    '' => 'Semua Aspek',
                    ...AspekPenilaian::orderBy('kode_aspek')->pluck('nama_aspek', 'id_aspek')->toArray()
                ]),

            SelectFilter::make('Kelompok Usia', 'kelompok_usia')
                ->options([
                    '' => 'Semua Usia',
                    '2-3_tahun' => '2-3 Tahun',
                    '3-4_tahun' => '3-4 Tahun',
                    '4-5_tahun' => '4-5 Tahun',
                    '5-6_tahun' => '5-6 Tahun',
                ]),

            SelectFilter::make('Status', 'is_active')
                ->options([
                    '' => 'Semua Status',
                    '1' => 'Aktif',
                    '0' => 'Nonaktif',
                ]),
        ];
    }

    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return Indikator::query()
    ->with(['aspekPenilaian', 'subAspek'])
    ->orderBy('indikator.aspek_id')         // Tambahkan nama tabel
    ->orderBy('indikator.sub_aspek_id')
    ->orderBy('indikator.kode_indikator');
    }
}
