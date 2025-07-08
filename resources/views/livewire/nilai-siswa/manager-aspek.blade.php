{{-- resources/views/livewire/nilai-siswa/manager-aspek.blade.php --}}
<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pilih Aspek Penilaian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Card -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Aspek Perkembangan Anak</h3>
                        <p class="text-gray-600 mt-1">Pilih aspek perkembangan untuk memulai penilaian siswa</p>
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
                        <x-input wire:model.live="search" type="text" placeholder="Cari aspek penilaian..."
                            class="w-full" />
                    </div>
                    <x-select wire:model.live="perPage" class="w-48">
                        <option value="6">6 per halaman</option>
                        <option value="12">12 per halaman</option>
                        <option value="24">24 per halaman</option>
                    </x-select>
                </div>
            </div>

            <!-- Aspek Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                @forelse ($aspeks as $aspek)
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg hover:shadow-2xl hover:scale-105 transition-all duration-200 cursor-pointer group"
                        wire:click="selectAspek({{ $aspek->id_aspek }})">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div
                                    class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-md text-sm font-medium group-hover:bg-indigo-100 transition-colors">
                                    {{ $aspek->kode_aspek }}
                                </div>
                                <div
                                    class="w-3 h-3 bg-green-400 rounded-full opacity-70 group-hover:opacity-100 transition-opacity">
                                </div>
                            </div>

                            <h3
                                class="text-xl font-bold text-gray-900 mb-3 group-hover:text-indigo-600 transition-colors">
                                {{ $aspek->nama_aspek }}
                            </h3>

                            <p class="text-gray-600 text-sm mb-6 line-clamp-3">
                                {{ $aspek->kategori ?? 'Aspek perkembangan anak usia dini yang penting untuk dipantau secara berkala untuk memastikan tumbuh kembang yang optimal.' }}
                            </p>

                            <!-- Indikator Count & Action -->
                            @php
                                $indikatorCount = $aspek->indikator ? $aspek->indikator->count() : 0;
                            @endphp
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h6a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                        </path>
                                    </svg>
                                    {{ $indikatorCount }} indikator
                                </div>

                                <div
                                    class="flex items-center text-indigo-600 group-hover:text-indigo-700 transition-colors">
                                    <span class="text-sm font-medium mr-2">Mulai Penilaian</span>
                                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Progress Bar (if any assessments exist) -->
                        <div class="bg-gray-50 px-6 py-3 border-t">
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <span>Progress hari ini</span>
                                <span>--/--</span>
                            </div>
                            <div class="mt-1 w-full bg-gray-200 rounded-full h-1">
                                <div class="bg-indigo-600 h-1 rounded-full" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-12 text-center">
                            <div
                                class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada aspek ditemukan</h3>
                            <p class="text-gray-500">Coba ubah kata kunci pencarian Anda atau hubungi administrator</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Quick Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div
                    class="bg-gradient-to-r from-blue-500 to-blue-600 overflow-hidden shadow-xl sm:rounded-lg p-6 text-white">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold">Sistem Penilaian</h4>
                            <p class="text-blue-100 text-sm">Berbasis 6 aspek perkembangan anak</p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-r from-green-500 to-green-600 overflow-hidden shadow-xl sm:rounded-lg p-6 text-white">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-green-200" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2-2V7a2 2 0 012-2h2a2 2 0 002 2v2a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 00-2 2h-2a2 2 0 00-2 2v6a2 2 0 01-2 2H9a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold">Skala Penilaian</h4>
                            <p class="text-green-100 text-sm">BB, MB, BSH, BSB (1-4)</p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-r from-purple-500 to-purple-600 overflow-hidden shadow-xl sm:rounded-lg p-6 text-white">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-purple-200" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold">Assessment Matrix</h4>
                            <p class="text-purple-100 text-sm">Input cepat untuk semua siswa</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            @if ($aspeks->hasPages())
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                    {{ $aspeks->links() }}
                </div>
            @endif
        </div>
    </div>

    <style>
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Hover effects */
        .group:hover {
            transform: translateY(-2px);
        }

        /* Loading states */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        /* Responsive improvements */
        @media (max-width: 640px) {
            .grid-cols-1 {
                gap: 1rem;
            }
        }
    </style>
</div>
