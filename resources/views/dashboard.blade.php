<x-app-layout>
    @php
        $id = Auth::guard('siswa')->user()->id_akunsiswa;
    @endphp
    <div class="min-h-screen bg-gray-50">
        <div class="w-full mx-auto px-4 py-8 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="bg-blue-600 rounded-2xl shadow-xl p-6 text-white">
                    <h1 class="text-3xl font-bold mb-2">Dashboard Siswa</h1>
                    <p class="text-blue-100 text-lg">Pantau perkembangan dan prestasi akademik</p>
                </div>
            </div>

            <!-- Quick Actions Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Chart Button Card -->
                <div
                    class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="p-3 bg-purple-500 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-800">Analisis Grafik</h3>
                                <p class="text-gray-600 text-sm">Visualisasi data prestasi</p>
                            </div>
                        </div>
                        <button id="openChartModal"
                            class="w-full bg-purple-500 hover:bg-purple-600 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-purple-300">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Tampilkan Grafik
                            </span>
                        </button>
                    </div>
                </div>

                <!-- Send Report Card -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="p-3 bg-green-500 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-800">Kirim Laporan</h3>
                                <p class="text-gray-600 text-sm">Bagikan progress siswa</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            @livewire('send-student-report', ['id_akunsiswa' => $id])
                        </div>
                    </div>
                </div>

            </div>

            <!-- Main Content Area -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-slate-800 px-8 py-6">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <svg class="w-7 h-7 mr-3 text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                        Detail Penilaian Siswa
                    </h2>
                    <p class="text-slate-300 mt-2">Data lengkap perkembangan akademik dan non-akademik</p>
                </div>

                <div class="p-8">
                    @livewire('detail-penilaian-siswa', ['siswaId' => $id, 'viewOnly' => true])
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Modal with Glassmorphism Effect -->
    <div id="chartModal" class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6 sm:px-0 hidden">
        <!-- Enhanced Backdrop with Blur -->
        <div id="chartModalBackdrop" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

        <!-- Modal Box with Glassmorphism -->
        <div
            class="relative bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden transform transition-all sm:max-w-4xl w-full border border-white/20">
            <!-- Enhanced Header -->
            <div class="bg-blue-600 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-white flex items-center">
                            <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                            Analisis Grafik Siswa
                        </h3>
                        <p class="text-blue-100 mt-1">Visualisasi data perkembangan akademik</p>
                    </div>
                    <button id="closeChartModal"
                        class="text-white hover:text-gray-200 transition-colors duration-200 p-2 hover:bg-blue-700 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Enhanced Tab System -->
            <div class="px-8 py-6">
                <!-- Modern Tab Buttons -->
                <div class="mb-8">
                    <div class="flex space-x-2 bg-gray-100 p-1 rounded-xl">
                        <button id="tabBtnWeekly"
                            class="flex-1 py-3 px-6 text-sm font-semibold rounded-lg transition-all duration-300 bg-blue-600 text-white shadow-lg">
                            <span class="flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Perkembangan Mingguan
                            </span>
                        </button>
                        <button id="tabBtnTopAspect"
                            class="flex-1 py-3 px-6 text-sm font-semibold rounded-lg transition-all duration-300 text-gray-600 hover:text-gray-800 hover:bg-gray-200">
                            <span class="flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                    </path>
                                </svg>
                                Top Aspect Minggu Ini
                            </span>
                        </button>
                    </div>
                </div>

                <!-- Tab Content Areas -->
                <div class="min-h-[400px]">
                    <!-- Tab Content: Weekly Progress -->
                    <div id="tabContentWeekly" class="animate-fadeIn">
                        <div class="bg-blue-50 rounded-2xl p-6 border border-blue-200">
                            @livewire('weekly-progress', ['id_akunsiswa' => $id])
                        </div>
                    </div>

                    <!-- Tab Content: Top Aspect -->
                    <div id="tabContentTopAspect" class="hidden animate-fadeIn">
                        <div class="bg-purple-50 rounded-2xl p-6 border border-purple-200">
                            @livewire('top-aspect-this-week', ['id_akunsiswa' => $id])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced JavaScript with Smooth Animations -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Modal elements
            const openBtn = document.getElementById('openChartModal');
            const closeBtn = document.getElementById('closeChartModal');
            const modal = document.getElementById('chartModal');
            const backdrop = document.getElementById('chartModalBackdrop');

            // Tab elements
            const tabBtnWeekly = document.getElementById('tabBtnWeekly');
            const tabBtnTopAspect = document.getElementById('tabBtnTopAspect');
            const tabContentWeekly = document.getElementById('tabContentWeekly');
            const tabContentTopAspect = document.getElementById('tabContentTopAspect');

            // Modal functions with enhanced isolation
            function openModal() {
                modal.classList.remove('hidden');
                modal.style.zIndex = '9999';
                setTimeout(() => {
                    modal.classList.add('animate-fadeIn');
                }, 10);
                activateWeeklyTab();
                document.body.style.overflow = 'hidden';

                // Isolate modal from other elements
                document.body.classList.add('modal-open');
            }

            function closeModal() {
                modal.classList.remove('animate-fadeIn');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                    document.body.classList.remove('modal-open');
                }, 200);
            }

            // Event listeners for modal
            openBtn.addEventListener('click', openModal);
            closeBtn.addEventListener('click', closeModal);
            backdrop.addEventListener('click', closeModal);

            // Enhanced keyboard support
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });

            // Enhanced tab functions
            function activateWeeklyTab() {
                // Show/hide content
                tabContentWeekly.classList.remove('hidden');
                tabContentTopAspect.classList.add('hidden');

                // Update button styles with smooth transitions
                tabBtnWeekly.classList.remove('text-gray-600', 'hover:text-gray-800', 'hover:bg-gray-200');
                tabBtnWeekly.classList.add('bg-blue-600', 'text-white', 'shadow-lg');

                tabBtnTopAspect.classList.remove('bg-blue-600', 'text-white', 'shadow-lg');
                tabBtnTopAspect.classList.add('text-gray-600', 'hover:text-gray-800', 'hover:bg-gray-200');
            }

            function activateTopAspectTab() {
                // Show/hide content
                tabContentWeekly.classList.add('hidden');
                tabContentTopAspect.classList.remove('hidden');

                // Update button styles with smooth transitions
                tabBtnTopAspect.classList.remove('text-gray-600', 'hover:text-gray-800', 'hover:bg-gray-200');
                tabBtnTopAspect.classList.add('bg-blue-600', 'text-white', 'shadow-lg');

                tabBtnWeekly.classList.remove('bg-blue-600', 'text-white', 'shadow-lg');
                tabBtnWeekly.classList.add('text-gray-600', 'hover:text-gray-800', 'hover:bg-gray-200');
            }

            // Tab event listeners
            tabBtnWeekly.addEventListener('click', activateWeeklyTab);
            tabBtnTopAspect.addEventListener('click', activateTopAspectTab);

            // Add smooth scroll behavior
            document.documentElement.style.scrollBehavior = 'smooth';
        });
    </script>

    <!-- Additional CSS for animations -->
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }

        /* Custom scrollbar for webkit browsers */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(45deg, #3b82f6, #6366f1);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(45deg, #2563eb, #4f46e5);
        }
    </style>
</x-app-layout>
