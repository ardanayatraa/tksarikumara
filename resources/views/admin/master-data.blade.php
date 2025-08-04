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
                <h3 class="text-xl font-semibold text-gray-800 p-4 border rounded-lg mb-4">Aspek Penilaian Management
                </h3>

                <!-- Inner Tabs for Aspek, Sub Aspek, Indikator -->
                <div class="inner-tabs mb-6">
                    <div class="flex space-x-4 border-b border-gray-300">
                        <button class="inner-tab-button py-2 px-4 font-medium text-gray-500 hover:text-blue-600"
                            data-tab="inner-aspek">Aspek</button>
                        <button class="inner-tab-button py-2 px-4 font-medium text-gray-500 hover:text-blue-600"
                            data-tab="inner-subaspek">Sub Aspek</button>
                        <button class="inner-tab-button py-2 px-4 font-medium text-gray-500 hover:text-blue-600"
                            data-tab="inner-indikator">Indikator</button>
                    </div>
                </div>

                <!-- Inner Panels -->
                <div class="inner-panels">
                    <!-- Panel Aspek -->
                    <div id="inner-aspek" class="inner-panel hidden">
                        <div class="p-4 border rounded-lg mb-4">
                            @livewire('aspek-penilaian.add')
                        </div>
                        <div class="p-4 border rounded-lg mb-4">
                            @livewire('table.aspek-penilaian-table')
                        </div>
                        @livewire('aspek-penilaian.update')
                        @livewire('aspek-penilaian.delete')
                    </div>

                    <!-- Panel Sub Aspek -->
                    <div id="inner-subaspek" class="inner-panel hidden">
                        <div class="p-4 border rounded-lg mb-4">
                            @livewire('sub-aspek.create')

                            <div class="my-6">
                                @livewire('sub-aspek.update')
                                @livewire('sub-aspek.delete')
                            </div>
                        </div>
                        <div class="p-4 border rounded-lg mb-4">
                            @livewire('table.sub-aspek-table')
                        </div>
                    </div>

                    <!-- Panel Indikator -->
                    <div id="inner-indikator" class="inner-panel hidden">
                        <div class="p-4 border rounded-lg mb-4">
                            @livewire('indikator.create')
                        </div>
                        <div class="p-4 border rounded-lg mb-4">
                            @livewire('table.aspek-penilaian-table')
                        </div>
                        @livewire('indikator.update')
                        @livewire('indikator.delete')
                    </div>
                </div>
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

            // Inner tab functionality
            const innerTabs = document.querySelectorAll('.inner-tab-button');
            const innerPanels = document.querySelectorAll('.inner-panel');

            function resetInnerTabs() {
                innerTabs.forEach(tab => {
                    tab.classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');
                });
                innerPanels.forEach(panel => panel.classList.add('hidden'));
            }

            function activateInnerTab(tabElement, tabName) {
                resetInnerTabs();
                tabElement.classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
                document.getElementById(tabName).classList.remove('hidden');
            }

            // Event listeners for inner tabs
            innerTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const tabName = this.getAttribute('data-tab');
                    activateInnerTab(this, tabName);
                });
            });

            // Aktifkan inner tab pertama (Aspek) secara default
            const firstInnerTab = document.querySelector('.inner-tab-button');
            if (firstInnerTab) {
                const defaultTab = firstInnerTab.getAttribute('data-tab');
                activateInnerTab(firstInnerTab, defaultTab);
            }
        });
    </script>
</x-app-layout>
