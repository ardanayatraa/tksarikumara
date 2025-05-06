<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Guru;

class GuruTable extends DataTableComponent
{
    protected $model = Guru::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id_guru');
    }

    public function columns(): array
    {
        return [
            Column::make("Id guru", "id_guru")->sortable(),
            Column::make("Nama",     "namaGuru")->sortable(),
            Column::make("NIP",      "nip")->sortable(),
            Column::make("Username", "username")->sortable(),
            Column::make("Email",    "email")->sortable(),
            Column::make("JK",       "jenis_kelamin")->sortable(),
            Column::make("No. Tlp",  "notlp")->sortable(),

            Column::make('Actions')
                ->label(fn($row) => view('components.table-action', [
                    'id' => $row->id_guru,
                ]))
                ->html(),
        ];
    }

    public function edit($id)
    {

        $this->dispatch('editGuru', $id);
    }

    public function delete($id)
    {
        $this->dispatch('deleteGuru',$id);
    }
}
