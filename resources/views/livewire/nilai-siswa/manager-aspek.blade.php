<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Pilih Aspek Penilaian</h1>
                    <p class="text-gray-600 mt-1">Pilih aspek untuk memulai proses penilaian</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-sm text-gray-500">
                        Total: {{ $aspeks->total() }} aspek
                    </div>
                </div>
            </div>

            <!-- Search & Filter -->
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <input wire:model.live="search" type="text"
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Cari aspek penilaian...">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <select wire:model.live="perPage"
                    class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="6">6 per halaman</option>
                    <option value="12">12 per halaman</option>
                    <option value="24">24 per halaman</option>
                </select>
            </div>
        </div>

        <!-- Aspek Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            @forelse ($aspeks as $aspek)
                <div class="bg-white rounded-lg shadow-sm border hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="bg-blue-50 text-blue-700 px-3 py-1 rounded-md text-sm font-medium">
                                {{ $aspek->kode_aspek }}
                            </div>
                            <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                        </div>

                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            {{ $aspek->nama_aspek }}
                        </h3>

                        <p class="text-gray-600 text-sm mb-6 line-clamp-2">
                            {{ $aspek->deskripsi ?? 'Tidak ada deskripsi tersedia untuk aspek ini.' }}
                        </p>

                        <button wire:click="selectAspek({{ $aspek->id_aspek }})"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-4 rounded-lg transition-colors duration-200">
                            Pilih Aspek
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-lg shadow-sm border p-12 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada aspek ditemukan</h3>
                        <p class="text-gray-500">Coba ubah kata kunci pencarian Anda</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($aspeks->hasPages())
            <div class="bg-white rounded-lg shadow-sm border p-4">
                {{ $aspeks->links() }}
            </div>
        @endif
    </div>
</div>
