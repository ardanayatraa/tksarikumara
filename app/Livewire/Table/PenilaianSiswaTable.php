<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\AkunSiswa;
use App\Models\Kelas;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PenilaianSiswaTable extends DataTableComponent
{
    protected $model = AkunSiswa::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id_akunsiswa')
             ->setFilterLayoutSlideDown()   // slide-down filter
             ->setDefaultSort('namaSiswa', 'asc');
    }

    public function builder(): Builder
    {
        // eager-load relasi kelas
        return AkunSiswa::query()->with('kelas');
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Kelas')
                ->options(
                    Kelas::orderBy('namaKelas')
                         ->pluck('namaKelas', 'id_kelas')
                         ->toArray()
                )
                ->filter(fn($builder, $value) => $builder->where('id_kelas', $value)),

            SelectFilter::make('Status')
                ->options([
                    'TK-A'               => 'TK-A',
                    'TK-B'               => 'TK-B',
                    'LULUS'              => 'Lulus',
                    'BELUM-DITENTUKAN'   => 'Belum Ditentukan',
                ])
                ->filter(fn($builder, $value) => $builder->where('status', $value)),
        ];
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id_akunsiswa')
                ->sortable(),

            Column::make('Kelas', 'kelas.namaKelas')
                ->sortable()
              ,

            Column::make('NISN', 'nisn')
                ->sortable(),

            Column::make('Nama Siswa', 'namaSiswa')
                ->sortable(),

            Column::make('Tgl Lahir', 'tgl_lahir')
                ->sortable()
                ->format(fn($value) => \Carbon\Carbon::parse($value)->format('d-m-Y')),

            Column::make('Jenis Kelamin', 'jenis_kelamin')
                ->sortable()
                ->format(fn($value) => $value === 'L' ? 'Laki-laki' : 'Perempuan'),

            Column::make('Alamat', 'alamat')
                ->sortable()
          ,

            Column::make('Email', 'email')
                ->sortable(),

            Column::make('Username', 'username')
                ->sortable(),

            Column::make('Status', 'status')
                ->sortable()
                ->format(fn($value) => match($value) {
                    'TK-A'             => 'TK-A',
                    'TK-B'             => 'TK-B',
                    'LULUS'            => 'Lulus',
                    'BELUM-DITENTUKAN' => 'Belum Ditentukan',
                    default            => $value,
                }),

            Column::make('Actions')
                ->label(fn($row) => view('components.table-action', [
                    'id' => $row->id_akunsiswa,
                ]))
                ->html(),
        ];
    }

    public function edit($id): void
    {
        $this->dispatch('editSiswa', $id);
    }

    public function delete($id): void
    {
        $this->dispatch('deleteSiswa', $id);
    }
}
