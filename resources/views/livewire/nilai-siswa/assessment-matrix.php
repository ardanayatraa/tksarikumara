{{-- resources/views/livewire/nilai-siswa/jetstream-assessment-matrix.blade.php --}}
<div>
    <!-- Page Header -->
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <button wire:click="backToAspek"
                        class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Penilaian {{ $aspek->nama_aspek }}
                    </h2>
                    <p class="text-gray-600 text-sm">{{ $aspek->kode_aspek }} - {{ now()->format('d M Y') }}</p>
                </div>
            </div>

            <!-- Progress & Controls -->
            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <div class="text-sm text-gray-500">Progress Hari Ini</div>
                    <div class="text-lg font-bold text-gray-900">{{ $progress['completed'] }}/{{ $progress['total'] }}</div>
                </div>
                <div class="w-32 bg-gray-200 rounded-full h-3">
                    <div class="bg-green-600 h-3 rounded-full transition-all duration-500" style="width: {{ $progress['percentage'] }}%"></div>
                </div>
                <span class="text-lg font-bold text-green-600">{{ $progress['percentage'] }}%</span>

                <button wire:click="toggleBulkMode"
                        class="px-4 py-2 {{ $bulkMode ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700' }} rounded-md transition-colors">
                    {{ $bulkMode ? 'Mode Normal' : 'Mode Bulk' }}
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <!-- Search & Info Card -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex-1 max-w-md">
                        <x-input wire:model.live="search"
                                type="text"
                                placeholder="Cari siswa atau kelas..."
                                class="w-full" />
                    </div>

                    <div class="text-sm text-gray-600">
                        {{ $progress['siswa_count'] }} siswa × {{ $progress['indikator_count'] }} indikator = {{ $progress['total'] }} penilaian
                    </div>
                </div>

                <!-- Quick Info -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ $progress['completed'] }}</div>
                        <div class="text-sm text-green-800">Selesai</div>
                    </div>
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ $progress['total'] - $progress['completed'] }}</div>
                        <div class="text-sm text-blue-800">Pending</div>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600">{{ $progress['siswa_count'] }}</div>
                        <div class="text-sm text-purple-800">Total Siswa</div>
                    </div>
                    <div class="text-center p-4 bg-orange-50 rounded-lg">
                        <div class="text-2xl font-bold text-orange-600">{{ $progress['indikator_count'] }}</div>
                        <div class="text-sm text-orange-800">Total Indikator</div>
                    </div>
                </div>
            </div>

            <!-- Assessment Matrix -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="sticky left-0 bg-gray-50 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r z-20">
                                    Siswa
                                </th>
                                @foreach($indikatorList as $indikator)
                                <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-r min-w-36">
                                    <div class="space-y-2">
                                        <div class="font-bold">{{ $indikator->kode_indikator }}</div>
                                        <div class="text-xs normal-case max-w-32 mx-auto leading-tight">{{ $indikator->nama_indikator }}</div>

                                        @if($indikator->min_umur && $indikator->max_umur)
                                        <div class="text-xs text-indigo-600">{{ $indikator->min_umur }}-{{ $indikator->max_umur }} th</div>
                                        @endif

                                        <!-- Quick Fill per Indikator -->
                                        <div class="flex justify-center space-x-1 mt-2">
                                            @foreach(['BSB', 'BSH', 'MB', 'BB'] as $nilai)
                                            <x-button wire:click="quickFillIndikator({{ $indikator->id }}, '{{ $nilai }}')"
                                                    class="px-1 py-0.5 text-xs {{ $nilai === 'BSB' ? 'bg-green-100 text-green-700 hover:bg-green-200' : '' }}
                                                           {{ $nilai === 'BSH' ? 'bg-blue-100 text-blue-700 hover:bg-blue-200' : '' }}
                                                           {{ $nilai === 'MB' ? 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' : '' }}
                                                           {{ $nilai === 'BB' ? 'bg-red-100 text-red-700 hover:bg-red-200' : '' }}"
                                                    title="Fill semua siswa dengan {{ $nilai }}">
                                                {{ $nilai }}
                                            </x-button>
                                            @endforeach
                                        </div>
                                    </div>
                                </th>
                                @endforeach
                                <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider min-w-24">
                                    Quick Fill
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($siswaList as $i => $siswa)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <!-- Siswa Info (Sticky Left) -->
                                <td class="sticky left-0 bg-white px-6 py-4 border-r z-10">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                                            <span class="text-sm font-bold text-indigo-600">
                                                {{ strtoupper(substr($siswa->namaSiswa, 0, 2)) }}
                                            </span>
                                        </div>
                                        <div class="min-w-0">
                                            <div class="text-sm font-medium text-gray-900">{{ $siswa->namaSiswa }}</div>
                                            <div class="text-xs text-gray-500">{{ $siswa->kelas->namaKelas }}</div>
                                            @if($siswa->jenis_kelamin)
                                            <div class="text-xs text-gray-400">{{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Nilai per Indikator -->
                                @foreach($indikatorList as $indikator)
                                @php
                                    $currentScore = $this->getCurrentScore($siswa->id_akunsiswa, $indikator->id);
                                    $isLoading = $this->isCellLoading($siswa->id_akunsiswa, $indikator->id);
                                @endphp
                                <td class="px-3 py-4 text-center border-r relative">
                                    <div class="space-y-2">
                                        <!-- Loading Overlay -->
                                        @if($isLoading)
                                        <div class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center z-10">
                                            <svg class="animate-spin h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </div>
                                        @endif

                                        <!-- Score Buttons -->
                                        <div class="grid grid-cols-2 gap-1">
                                            @foreach(['BSB', 'BSH', 'MB', 'BB'] as $nilai)
                                            <button wire:click="setNilai({{ $siswa->id_akunsiswa }}, {{ $indikator->id }}, '{{ $nilai }}', '{{ $currentScore['catatan'] }}')"
                                                    class="p-1 text-xs font-medium rounded transition-all duration-200 border
                                                           {{ $currentScore['nilai'] === $nilai ?
                                                              ($nilai === 'BSB' ? 'bg-green-500 text-white border-green-500' :
                                                               ($nilai === 'BSH' ? 'bg-blue-500 text-white border-blue-500' :
                                                                ($nilai === 'MB' ? 'bg-yellow-500 text-white border-yellow-500' :
                                                                 'bg-red-500 text-white border-red-500'))) :
                                                              ($nilai === 'BSB' ? 'bg-green-50 text-green-700 hover:bg-green-100 border-green-200' :
                                                               ($nilai === 'BSH' ? 'bg-blue-50 text-blue-700 hover:bg-blue-100 border-blue-200' :
                                                                ($nilai === 'MB' ? 'bg-yellow-50 text-yellow-700 hover:bg-yellow-100 border-yellow-200' :
                                                                 'bg-red-50 text-red-700 hover:bg-red-100 border-red-200'))) }}"
                                                    @if($isLoading) disabled @endif>
                                                {{ $nilai }}
                                            </button>
                                            @endforeach
                                        </div>

                                        <!-- Catatan -->
                                        <textarea wire:model.blur="currentScores.{{ $siswa->id_akunsiswa }}_{{ $indikator->id }}.catatan"
                                                  wire:change="updateCatatan({{ $siswa->id_akunsiswa }}, {{ $indikator->id }}, $event.target.value)"
                                                  placeholder="Catatan..."
                                                  class="w-full text-xs border border-gray-300 rounded p-1 resize-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                                  rows="2"
                                                  @if($isLoading) disabled @endif>{{ $currentScore['catatan'] }}</textarea>
                                    </div>
                                </td>
                                @endforeach

                                <!-- Quick Fill per Siswa -->
                                <td class="px-3 py-4 text-center">
                                    <div class="space-y-1">
                                        @foreach(['BSB', 'BSH', 'MB', 'BB'] as $nilai)
                                        <x-button wire:click="quickFillSiswa({{ $siswa->id_akunsiswa }}, '{{ $nilai }}')"
                                                class="w-full px-2 py-1 text-xs
                                                       {{ $nilai === 'BSB' ? 'bg-green-100 text-green-700 hover:bg-green-200' : '' }}
                                                       {{ $nilai === 'BSH' ? 'bg-blue-100 text-blue-700 hover:bg-blue-200' : '' }}
                                                       {{ $nilai === 'MB' ? 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' : '' }}
                                                       {{ $nilai === 'BB' ? 'bg-red-100 text-red-700 hover:bg-red-200' : '' }}"
                                                title="Fill semua indikator dengan {{ $nilai }}">
                                            {{ $nilai }}
                                        </x-button>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ count($indikatorList) + 2 }}" class="px-6 py-12 text-center">
                                    <div class="text-gray-500">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada siswa ditemukan</h3>
                                        <p class="mt-1 text-sm text-gray-500">Coba ubah kata kunci pencarian Anda</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if(!$bulkMode && $siswaList->hasPages())
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-6 p-4">
                {{ $siswaList->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Toast Notifications -->
    <div x-data="{
        notifications: @entangle('notifications').defer,
        show: false,
        message: '',
        type: 'info'
    }"
         x-on:show-notification.window="
            message = $event.detail[0].message;
            type = $event.detail[0].type;
            show = true;
            setTimeout(() => show = false, 5000)
         "
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-x-full"
         x-transition:enter-end="opacity-100 transform translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-x-0"
         x-transition:leave-end="opacity-0 transform translate-x-full"
         class="fixed top-4 right-4 z-50 max-w-sm w-full"
         style="display: none;">

        <div :class="{
                'bg-green-500': type === 'success',
                'bg-red-500': type === 'error',
                'bg-yellow-500': type === 'warning',
                'bg-blue-500': type === 'info'
             }"
             class="rounded-lg shadow-lg p-4 text-white">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg x-show="type === 'success'" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <svg x-show="type === 'error'" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <svg x-show="type === 'warning'" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <svg x-show="type === 'info'" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium" x-text="message"></p>
                </div>
                <div class="ml-4 flex-shrink-0">
                    <button @click="show = false" class="inline-flex text-white hover:text-gray-200 focus:outline-none">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom scrollbar */
        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Sticky column shadow */
        .sticky.left-0 {
            box-shadow: 2px 0 4px rgba(0,0,0,0.1);
        }

        /* Loading animation */
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }

        /* Button transitions */
        button {
            transition: all 0.2s ease-in-out;
        }

        button:hover {
            transform: translateY(-1px);
        }

        button:active {
            transform: translateY(0);
        }

        /* Focus states for accessibility */
        button:focus,
        textarea:focus,
        input:focus {
            outline: 2px solid #6366f1;
            outline-offset: 2px;
        }

        /* Responsive table */
        @media (max-width: 768px) {
            .min-w-36 {
                min-width: 120px;
            }

            .sticky.left-0 {
                min-width: 140px;
                max-width: 140px;
            }
        }

        /* Print styles */
        @media print {
            .sticky {
                position: static !important;
            }

            button {
                display: none !important;
            }

            .overflow-x-auto {
                overflow: visible !important;
            }

            table {
                width: 100% !important;
                min-width: auto !important;
            }
        }
    </style>

    <!-- Scripts -->
    <script>
        // Livewire hooks
        document.addEventListener('livewire:init', () => {
            // Listen for notifications
            Livewire.on('showNotification', (data) => {
                window.dispatchEvent(new CustomEvent('show-notification', {
                    detail: data
                }));
            });
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl+S to save (prevent browser save)
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                // Show notification
                window.dispatchEvent(new CustomEvent('show-notification', {
                    detail: [{
                        message: 'Data tersimpan otomatis saat input',
                        type: 'info'
                    }]
                }));
            }

            // Number keys 1-4 for quick scoring (when not in input/textarea)
            if (e.key >= '1' && e.key <= '4' && !e.target.matches('input, textarea')) {
                const scores = ['BB', 'MB', 'BSH', 'BSB'];
                const score = scores[parseInt(e.key) - 1];

                // Find focused cell or first visible cell
                const buttons = document.querySelectorAll(`button[wire\\:click*="setNilai"]`);
                if (buttons.length > 0) {
                    // Focus first button for demonstration
                    console.log(`Quick score: ${score} (${e.key})`);
                }
            }
        });

        // Auto-scroll helper for large tables
        function scrollToActiveCell() {
            const activeCell = document.querySelector('button:focus').closest('td');
            if (activeCell) {
                activeCell.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center',
                    inline: 'center'
                });
            }
        }

        // Add loading state to buttons when clicked
        document.addEventListener('click', function(e) {
            if (e.target.matches('button[wire\\:click*="setNilai"]')) {
                const button = e.target;
                const originalText = button.textContent;

                // Add loading state
                button.disabled = true;
                button.innerHTML = '<svg class="animate-spin h-3 w-3 mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

                // Reset after a short delay (Livewire will handle the actual update)
                setTimeout(() => {
                    button.disabled = false;
                    button.textContent = originalText;
                }, 500);
            }
        });
    </script>
</div>
