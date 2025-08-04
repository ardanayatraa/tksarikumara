<?php

namespace App\Livewire\Table;

use App\Models\Indikator;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class AspekPenilaianTable extends DataTableComponent
{
    protected $model = Indikator::class;

    public function configure(): void
    {
        // primary key sesuai migration: $table->id()
        $this->setPrimaryKey('id_indikator');

        // Enable filters
        $this->setFiltersStatus(true);
        $this->setFiltersVisibilityStatus(true);

        // Optional: Set default filter layout
        $this->setFilterLayoutSlideDown();
    }

    public function builder(): Builder
    {
        // eager-load relasi ke aspek utama
        return Indikator::query()
            ->with('aspekPenilaian');
    }

    public function filters(): array
    {
        $ageRanges = [
            ['min' => 2, 'max' => 3],
            ['min' => 3, 'max' => 4],
            ['min' => 4, 'max' => 5],
            ['min' => 5, 'max' => 6],
        ];

        // Create options for the filter
        $options = ['' => 'Semua Rentang Umur'];

        foreach ($ageRanges as $index => $range) {
            $key = $range['min'] . '-' . $range['max'];
            $options[$key] = $range['min'] . ' - ' . $range['max'] . ' Tahun';
        }

        return [
            SelectFilter::make('Rentang Umur', 'age_range')
                ->options($options)
                ->filter(function(Builder $builder, string $value) {
                    if ($value) {
                        $range = explode('-', $value);
                        $minAge = (int) $range[0];
                        $maxAge = (int) $range[1];

                        return $builder->where(function($query) use ($minAge, $maxAge) {
                            $query->where(function($subQuery) use ($minAge, $maxAge) {
                                // Indikator yang rentang umurnya overlap dengan filter yang dipilih
                                $subQuery->where('min_umur', '<=', $maxAge)
                                        ->where('max_umur', '>=', $minAge);
                            });
                        });
                    }
                    return $builder;
                }),
        ];
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id_indikator')
                ->sortable(),

            Column::make('Kode Aspek', 'aspekPenilaian.kode_aspek')
                ->sortable(),
            Column::make('Aspek Penilaian', 'aspekPenilaian.nama_aspek')
                ->sortable(),

            Column::make('Kode Indikator', 'kode_indikator')
                ->sortable(),

            Column::make('Deskripsi Indikator', 'deskripsi_indikator')
                ->sortable(),

            Column::make('Kelompok Usia', 'kelompok_usia')
                ->format(fn($value) => str_replace('_', ' ', $value))
                ->sortable(),

            Column::make('Actions')
                ->label(fn($row) => view('components.table-action', [
                    'id' => $row->id_indikator,
                ]))
                ->html(),
        ];
    }

    public function edit($id_indikator): void
    {
        $this->dispatch('editIndikator', $id_indikator);
    }

    public function delete($id_indikator): void
    {
        $this->dispatch('deleteIndikator', $id_indikator);
    }
}
