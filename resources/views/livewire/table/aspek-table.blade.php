<div class="space-y-4">
    {{-- Controls --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-2">
            <span>Show</span>
            <select wire:model="perPage"
                class="block w-20 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option>5</option>
                <option>10</option>
                <option>25</option>
                <option>50</option>
            </select>
            <span>entries</span>
        </div>

        <div class="flex-grow">
            <x-input wire:model.debounce.500ms="search" placeholder="Cari nama atau kode aspek..."
                class="w-full sm:w-64" />
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 border border-gray-300 rounded-lg">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left">#</th>
                    <th class="px-4 py-2 text-left">Kode</th>
                    <th class="px-4 py-2 text-left">Nama Aspek</th>
                    <th class="px-4 py-2 text-left">Kategori</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                @forelse ($aspeks as $index => $aspek)
                    <tr>
                        <td class="px-4 py-2">{{ $aspeks->firstItem() + $index }}</td>
                        <td class="px-4 py-2">{{ $aspek->kode_aspek }}</td>
                        <td class="px-4 py-2">{{ $aspek->nama_aspek }}</td>
                        <td class="px-4 py-2">{{ $aspek->kategori }}</td>
                        <td class="px-4 py-2 space-x-2">
                            <x-button wire:click="$emit('editAspek', {{ $aspek->id_aspek }})" class="text-sm">
                                Edit
                            </x-button>
                            <x-danger-button wire:click="$emit('deleteAspek', {{ $aspek->id_aspek }})" class="text-sm">
                                Hapus
                            </x-danger-button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center text-gray-500">
                            Tidak ada data ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div>
        {{ $aspeks->links() }}
    </div>
</div>
