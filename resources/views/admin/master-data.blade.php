<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Master Data') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-white rounded-lg shadow-md">
        <!-- Tab Navigation -->
        <div class="mb-6">
            <div class="border-b border-gray-300 flex space-x-4">
                <!-- Kelas Tab -->
                <button id="tab-kelas"
                    class="tab-button pb-2 px-4 text-lg font-semibold text-gray-500 hover:text-blue-600">
                    Kelas
                </button>

                <!-- Aspek Penilaian Tab -->
                <button id="tab-aspek"
                    class="tab-button pb-2 px-4 text-lg font-semibold text-gray-500 hover:text-blue-600">
                    Aspek Penilaian
                </button>

                <!-- Semester Tab -->
                <button id="tab-semester"
                    class="tab-button pb-2 px-4 text-lg font-semibold text-gray-500 hover:text-blue-600">
                    Semester
                </button>
            </div>
        </div>

        <div class="tab-content space-y-6">
            <!-- Kelas Panel -->
            <div id="content-kelas" class="tab-panel hidden flex flex-col space-y-4">
                <h3 class="text-xl font-semibold text-gray-800 p-4 border rounded-lg mb-4">Kelas Management</h3>
                <div class="p-4 border rounded-lg mb-4">
                    @livewire('kelas.add')

                </div>
                <div class="p-4 border rounded-lg mb-4">
                    @livewire('table.kelasTable')
                </div>

                @livewire('kelas.update')
                @livewire('kelas.delete')
            </div>

            <!-- Aspek Penilaian Panel -->
            <div id="content-aspek" class="tab-panel hidden flex flex-col space-y-4">
                <h3 class="text-xl font-semibold text-gray-800 p-4 border rounded-lg mb-4">Semester Management</h3>
                <div class="p-4 border rounded-lg mb-4">
                    @livewire('semester.add')

                </div>
                <div class="p-4 border rounded-lg mb-4">
                    @livewire('table.semesterTable')
                </div>

                @livewire('semester.update')
                @livewire('semester.delete')
            </div>

            <!-- Semester Panel -->
            <div id="content-semester" class="tab-panel hidden flex flex-col space-y-4">
                <h3 class="text-xl font-semibold text-gray-800 p-4 border rounded-lg mb-4">Semester Management</h3>
                <div class="p-4 border rounded-lg mb-4">
                    @livewire('aspek-penilaian.add')

                </div>
                <div class="p-4 border rounded-lg mb-4">
                    @livewire('table.aspek-penilaian-table')
                </div>

                @livewire('aspek-penilaian.update')
                @livewire('aspek-penilaian.delete')
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab-button');
            const panels = document.querySelectorAll('.tab-panel');

            function resetTabs() {
                tabs.forEach(tab => {
                    tab.classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');
                });
                panels.forEach(panel => panel.classList.add('hidden'));
            }

            function activateTab(tabId, contentId) {
                resetTabs();
                document.getElementById(tabId)
                    .classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
                document.getElementById(contentId)
                    .classList.remove('hidden');
            }

            // default active tab
            activateTab('tab-kelas', 'content-kelas');

            // event listeners
            document.getElementById('tab-kelas')
                .addEventListener('click', () => activateTab('tab-kelas', 'content-kelas'));
            document.getElementById('tab-aspek')
                .addEventListener('click', () => activateTab('tab-aspek', 'content-aspek'));
            document.getElementById('tab-semester')
                .addEventListener('click', () => activateTab('tab-semester', 'content-semester'));
        });
    </script>
</x-app-layout>
