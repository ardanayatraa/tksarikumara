<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Semester;

class SemesterTable extends DataTableComponent
{
    protected $model = Semester::class;

    public function configure(): void
    {
        // gunakan primary key yang sesuai
        $this->setPrimaryKey('id_semester');
    }

    public function columns(): array
    {
        return [
            Column::make('Id Semester', 'id_semester')
                ->sortable(),

            Column::make('Nama Semester', 'nama_semester')
                ->sortable(),

            Column::make('Tahun Awal', 'tahun_awal')
                ->sortable(),

            Column::make('Tahun Akhir', 'tahun_akhir')
                ->sortable(),

            Column::make('Created At', 'created_at')
                ->sortable(),

            Column::make('Updated At', 'updated_at')
                ->sortable(),

            Column::make('Actions')
                ->label(fn($row) => view('components.table-action', [
                    'id'          => $row->id_semester,

                ]))
                ->html(),
        ];
    }

    public function edit($id): void
    {
        $this->dispatch('editSemester', $id);
    }

    public function delete($id): void
    {
        $this->dispatch('deleteSemester', $id);
    }
}
