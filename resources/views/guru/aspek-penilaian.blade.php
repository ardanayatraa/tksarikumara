<x-app-layout>
    <div class="mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200" x-data="{ tab: 'aspek' }">
                <!-- Header -->
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Manajemen Aspek Penilaian</h2>
                    <p class="text-gray-600 mt-1">Kelola aspek penilaian, sub aspek, dan indikator untuk sistem penilaian
                        siswa</p>
                </div>

                <!-- Tabs Navigation -->
                <div class="flex border-b mb-6">
                    <button class="px-6 py-3 focus:outline-none transition-all duration-200"
                        :class="tab === 'aspek' ? 'border-b-2 border-indigo-500 font-semibold text-indigo-600 bg-indigo-50' :
                            'text-gray-500 hover:text-gray-700 hover:bg-gray-50'"
                        @click="tab = 'aspek'">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            Aspek Penilaian
                        </div>
                    </button>
                    <button class="ml-4 px-6 py-3 focus:outline-none transition-all duration-200"
                        :class="tab === 'subaspek' ? 'border-b-2 border-indigo-500 font-semibold text-indigo-600 bg-indigo-50' :
                            'text-gray-500 hover:text-gray-700 hover:bg-gray-50'"
                        @click="tab = 'subaspek'">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                            Sub Aspek
                        </div>
                    </button>
                    <button class="ml-4 px-6 py-3 focus:outline-none transition-all duration-200"
                        :class="tab === 'indikator' ?
                            'border-b-2 border-indigo-500 font-semibold text-indigo-600 bg-indigo-50' :
                            'text-gray-500 hover:text-gray-700 hover:bg-gray-50'"
                        @click="tab = 'indikator'">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                </path>
                            </svg>
                            Indikator
                        </div>
                    </button>
                </div>

                <!-- Tab: Aspek Penilaian -->
                <div x-show="tab === 'aspek'" x-cloak x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform translate-y-4"
                    x-transition:enter-end="opacity-100 transform translate-y-0">

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Manajemen Aspek Penilaian</h3>
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        Aspek penilaian adalah kategori utama dalam sistem penilaian. Setiap aspek dapat
                                        memiliki sub aspek dan indikator.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Components untuk Aspek -->
                    @livewire('aspek-penilaian.add-aspek')

                    <div class="my-6">
                        @livewire('aspek-penilaian.update-aspek')
                        @livewire('aspek-penilaian.delete-aspek')
                    </div>

                    <!-- Tabel Aspek -->
                    <div class="mt-6">
                        @livewire('table.aspek-table')
                    </div>
                </div>

                <!-- Tab: Sub Aspek -->
                <div x-show="tab === 'subaspek'" x-cloak x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform translate-y-4"
                    x-transition:enter-end="opacity-100 transform translate-y-0">

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Manajemen Sub Aspek</h3>
                        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700">
                                        Sub aspek adalah pembagian lebih detail dari aspek penilaian. Sub aspek bersifat
                                        opsional dan membantu mengorganisir indikator.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Components untuk Sub Aspek -->
                    @livewire('sub-aspek.create')

                    <div class="my-6">
                        @livewire('sub-aspek.update')
                        @livewire('sub-aspek.delete')
                    </div>

                    <!-- Tabel Sub Aspek -->
                    <div class="mt-6">
                        @livewire('table.sub-aspek-table')
                    </div>
                </div>

                <!-- Tab: Indikator -->
                <div x-show="tab === 'indikator'" x-cloak x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform translate-y-4"
                    x-transition:enter-end="opacity-100 transform translate-y-0">

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Manajemen Indikator Penilaian</h3>
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        Indikator adalah kriteria spesifik yang digunakan untuk menilai perkembangan
                                        siswa. Setiap indikator terkait dengan aspek atau sub aspek tertentu.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Components untuk Indikator -->
                    @livewire('indikator.create')

                    <div class="my-6">
                        @livewire('indikator.update')
                        @livewire('indikator.delete')
                    </div>

                    <!-- Tabel Indikator -->
                    <div class="mt-6">
                        @livewire('table.indikator-table')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</x-app-layout>
