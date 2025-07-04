<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
            <div class="flex items-center mb-6">
                <button wire:click="backToAspek"
                    class="mr-4 p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                </button>
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-900">Pilih Indikator</h1>
                    <p class="text-gray-600 mt-1">{{ $aspek->nama_aspek }}</p>
                </div>
                <div class="text-sm text-gray-500">
                    Total: {{ $indikators->total() }} indikator
                </div>
            </div>

            <!-- Search & Filter -->
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <input wire:model.live="search" type="text"
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            placeholder="Cari indikator...">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <select wire:model.live="perPage"
                    class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <option value="6">6 per halaman</option>
                    <option value="12">12 per halaman</option>
                    <option value="24">24 per halaman</option>
                </select>
            </div>
        </div>

        <!-- Indikator Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            @forelse ($indikators as $indikator)
                <div class="bg-white rounded-lg shadow-sm border hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="bg-green-50 text-green-700 px-3 py-1 rounded-md text-sm font-medium">
                                {{ $indikator->kode_indikator }}
                            </div>
                            <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                        </div>

                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            {{ $indikator->nama_indikator }}
                        </h3>

                        <p class="text-gray-600 text-sm mb-6 line-clamp-3">
                            {{ $indikator->deskripsi ?? 'Tidak ada deskripsi tersedia untuk indikator ini.' }}
                        </p>

                        <button wire:click="selectIndikator({{ $indikator->id }})"
                            class="w-full bg-green-600 text-black hover:bg-green-700 text-white font-medium py-2.5 px-4 rounded-lg transition-colors duration-200">
                            Pilih Indikator
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-lg shadow-sm border p-12 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2-2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada indikator ditemukan</h3>
                        <p class="text-gray-500">Coba ubah kata kunci pencarian Anda</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($indikators->hasPages())
            <div class="bg-white rounded-lg shadow-sm border p-4">
                {{ $indikators->links() }}
            </div>
        @endif
    </div>
</div>
