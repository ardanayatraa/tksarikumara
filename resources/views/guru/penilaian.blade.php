<x-app-layout>
    <div class="p-4 border bg-white">
        <div x-data="{ activeTab: 'siswa' }">
            <!-- Tab Header -->
            <nav class="flex space-x-4 border-b mb-4">
                <button class="px-4 py-2 -mb-px font-medium text-sm focus:outline-none"
                    :class="activeTab === 'siswa' ? 'border-indigo-500 text-indigo-600 border-b-2' :
                        'text-gray-500 hover:text-indigo-600'"
                    @click="activeTab = 'siswa'">
                    Daftar Siswa
                </button>

                <button class="px-4 py-2 -mb-px font-medium text-sm focus:outline-none"
                    :class="activeTab === 'penilaian' ? 'border-indigo-500 text-indigo-600 border-b-2' :
                        'text-gray-500 hover:text-indigo-600'"
                    @click="activeTab = 'penilaian'">
                    Penilaian
                </button>
            </nav>

            <!-- Content -->
            <div>
                <!-- List Siswa -->
                <div x-show="activeTab === 'siswa'" x-cloak>
                    @livewire('table.penilaian-siswa-table')
                </div>

                <!-- Penilaian -->
                <div x-show="activeTab === 'penilaian'" x-cloak>
                    @livewire('penilaian-aspek')

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
