<x-app-layout>
    <div class="mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200" x-data="{ tab: 'aspek' }">
                <!-- Tabs -->
                <div class="flex border-b mb-4">
                    <button class="px-4 py-2 focus:outline-none"
                        :class="tab === 'aspek' ? 'border-b-2 border-indigo-500 font-semibold text-indigo-600' :
                            'text-gray-500'"
                        @click="tab = 'aspek'">
                        Aspek Penilaian
                    </button>
                    <button class="ml-4 px-4 py-2 focus:outline-none"
                        :class="tab === 'indikator' ? 'border-b-2 border-indigo-500 font-semibold text-indigo-600' :
                            'text-gray-500'"
                        @click="tab = 'indikator'">
                        Indikator
                    </button>
                </div>

                <!-- Tab: Aspek Penilaian -->
                <div x-show="tab === 'aspek'" x-cloak>
                    @livewire('aspek-penilaian.add-aspek')
                    <br>
                    @livewire('aspek-penilaian.update-aspek')
                    @livewire('aspek-penilaian.delete-aspek')

                    @livewire('table.aspek-table')




                </div>

                <!-- Tab: Indikator -->
                <div x-show="tab === 'indikator'" x-cloak>

                    @livewire('aspek-penilaian.add')
                    <br>
                    @livewire('aspek-penilaian.update')
                    @livewire('aspek-penilaian.delete')
                    @livewire('table.aspek-penilaian-table')

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
