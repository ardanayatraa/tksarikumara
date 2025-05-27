<x-app-layout>

    <div class="mx-auto ">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            @livewire('send-student-report', ['id_akunsiswa' => $id])

            <div class="p-6 bg-white border-b border-gray-200">
                @livewire('weekly-progress', ['id_akunsiswa' => $id])
                @livewire('top-aspect-this-week', ['id_akunsiswa' => $id])

                @livewire('nilai-siswa.add', ['id_akunsiswa' => $id])
                @livewire('nilai-siswa.update', ['id_akunsiswa' => $id])
                @livewire('nilai-siswa.delete')
                @livewire('table.nilai-siswa-table')
            </div>
        </div>

</x-app-layout>
