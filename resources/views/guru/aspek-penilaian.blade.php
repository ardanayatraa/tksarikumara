<x-app-layout>
    <div class="mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b space-y-2 border-gray-200">
                @livewire('aspek-penilaian.add')
                @livewire('aspek-penilaian.update')
                @livewire('aspek-penilaian.delete')
                @livewire('table.aspek-penilaian-table')
            </div>
        </div>
    </div>
</x-app-layout>
