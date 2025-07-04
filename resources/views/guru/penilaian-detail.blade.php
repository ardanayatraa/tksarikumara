<x-app-layout>
    <div class="w-full mx-auto px-4 py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow sm:rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">

                <!-- Add Nilai Siswa, Send Student Report, & Tombol Grafik (3 kolom) -->
                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-8 bg-gray-50 p-4 rounded-md shadow-sm">


                    <!-- Kolom 2: Send Student Report (Rata Tengah) -->
                    <div class="w-full flex justify-center">
                        @livewire('send-student-report', ['id_akunsiswa' => $id])
                    </div>

                    <!-- Kolom 3: Tombol Buka Modal Grafik (Rata Tengah) -->
                    <div class="w-full flex justify-center">
                        <button id="openChartModal"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Tampilkan Grafik
                        </button>
                    </div>
                </div>

                @livewire('nilai-siswa.update', ['id_akunsiswa' => $id])
                @livewire('nilai-siswa.delete')

                <!-- Table Nilai Siswa -->
                <div class="md:col-span-2 bg-gray-50 p-4 rounded-md shadow-sm">
                    @livewire('table.nilai-siswa-table')
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Grafik dengan Tabs (Hidden by Default) -->
    <div id="chartModal" class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6 sm:px-0 hidden">
        <!-- Backdrop -->
        <div id="chartModalBackdrop" class="absolute inset-0 bg-black bg-opacity-50"></div>

        <!-- Modal Box -->
        <div
            class="relative bg-white rounded-lg shadow-xl overflow-hidden transform transition-all sm:max-w-2xl w-full">
            <!-- Header Modal -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Grafik Siswa</h3>
                <button id="closeChartModal" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Body Modal dengan Tab Headers -->
            <div class="px-6 py-4">
                <!-- Tab Buttons -->
                <div class="border-b border-gray-200 mb-4">
                    <nav class="-mb-px flex space-x-6">
                        <button id="tabBtnWeekly"
                            class="py-2 px-4 text-sm font-medium text-gray-700 border-b-2 border-blue-600 focus:outline-none">
                            Mingguan
                        </button>
                        <button id="tabBtnTopAspect"
                            class="py-2 px-4 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 focus:outline-none">
                            Top Aspect
                        </button>
                    </nav>
                </div>

                <!-- Tab Content: Mingguan -->
                <div id="tabContentWeekly">
                    @livewire('weekly-progress', ['id_akunsiswa' => $id])
                </div>

                <!-- Tab Content: Top Aspect (Hidden by Default) -->
                <div id="tabContentTopAspect" class="hidden">
                    @livewire('top-aspect-this-week', ['id_akunsiswa' => $id])
                </div>
            </div>
        </div>
    </div>

    <!-- Script JS Biasa untuk Kontrol Modal & Tabs -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elemen Modal
            const openBtn = document.getElementById('openChartModal');
            const closeBtn = document.getElementById('closeChartModal');
            const modal = document.getElementById('chartModal');
            const backdrop = document.getElementById('chartModalBackdrop');

            // Tab Buttons
            const tabBtnWeekly = document.getElementById('tabBtnWeekly');
            const tabBtnTopAspect = document.getElementById('tabBtnTopAspect');

            // Tab Contents
            const tabContentWeekly = document.getElementById('tabContentWeekly');
            const tabContentTopAspect = document.getElementById('tabContentTopAspect');

            // Buka modal
            function openModal() {
                modal.classList.remove('hidden');
                activateWeeklyTab();
            }

            // Tutup modal
            function closeModal() {
                modal.classList.add('hidden');
            }

            openBtn.addEventListener('click', openModal);
            closeBtn.addEventListener('click', closeModal);
            backdrop.addEventListener('click', closeModal);

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });

            // Fungsi untuk aktifkan Tab Mingguan
            function activateWeeklyTab() {
                tabContentWeekly.classList.remove('hidden');
                tabContentTopAspect.classList.add('hidden');

                tabBtnWeekly.classList.remove('text-gray-500', 'border-transparent');
                tabBtnWeekly.classList.add('text-gray-700', 'border-blue-600');
                tabBtnTopAspect.classList.remove('text-gray-700', 'border-blue-600');
                tabBtnTopAspect.classList.add('text-gray-500', 'border-transparent');
            }

            // Fungsi untuk aktifkan Tab Top Aspect
            function activateTopAspectTab() {
                tabContentWeekly.classList.add('hidden');
                tabContentTopAspect.classList.remove('hidden');

                tabBtnTopAspect.classList.remove('text-gray-500', 'border-transparent');
                tabBtnTopAspect.classList.add('text-gray-700', 'border-blue-600');
                tabBtnWeekly.classList.remove('text-gray-700', 'border-blue-600');
                tabBtnWeekly.classList.add('text-gray-500', 'border-transparent');
            }

            // Event Listener untuk Tab Buttons
            tabBtnWeekly.addEventListener('click', activateWeeklyTab);
            tabBtnTopAspect.addEventListener('click', activateTopAspectTab);
        });
    </script>
</x-app-layout>
