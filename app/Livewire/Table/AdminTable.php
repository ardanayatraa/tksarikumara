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
            Column::make("Id admin", "id_admin")
                ->sortable(),
            Column::make("Username", "username")
                ->sortable(),
            Column::make("Email", "email")
                ->sortable(),
            Column::make("Notlp", "notlp")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
