<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Admin;

class AdminTable extends DataTableComponent
{
    protected $model = Admin::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id_admin');

    }

    public function columns(): array
    {
        return [
            Column::make('Id admin', 'id_admin')
                ->sortable(),
            Column::make('Username', 'username')
                ->sortable()
                ->searchable(),

            Column::make('Email', 'email')
                ->sortable()
                ->searchable(),

            Column::make('No. Tlp', 'notlp')
                ->sortable(),



            Column::make('Actions')
                ->label(fn($row) => view('components.table-action', [
                    'id'          => $row->id_admin,
                    'editEvent'   => 'editAdmin',
                    'deleteEvent' => 'deleteAdmin',
                ]))
                ->html(),
        ];
    }

    public function edit($id): void
    {
        $this->dispatch('editAdmin', $id);
    }

    public function delete($id): void
    {
        $this->dispatch('deleteAdmin', $id);
    }
}
