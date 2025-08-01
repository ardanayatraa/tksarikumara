{{-- File: resources/views/livewire/indikator/create.blade.php --}}
<div>
    <x-button wire:click="$set('open', true)" class="bg-indigo-600 hover:bg-indigo-700">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Tambah Indikator
    </x-button>

    <x-dialog-modal wire:model="open" maxWidth="2xl">
        <x-slot name="title">Tambah Indikator Penilaian</x-slot>

        <x-slot name="content">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Aspek Utama --}}
                <div class="md:col-span-2">
                    <x-label for="aspek_id" value="Aspek Utama" />
                    <select id="aspek_id" wire:model.live="aspek_id"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">-- Pilih aspek --</option>
                        @foreach ($aspeks as $aspek)
                            <option value="{{ $aspek->id_aspek }}">
                                {{ $aspek->kode_aspek }}. {{ $aspek->nama_aspek }}
                            </option>
                        @endforeach
                    </select>
                    @error('aspek_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Sub Aspek --}}
                @if (count($subAspeks) > 0)
                    <div class="md:col-span-2">
                        <x-label for="sub_aspek_id" value="Sub Aspek" />
                        <select id="sub_aspek_id" wire:model.live="sub_aspek_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">-- Pilih sub aspek --</option>
                            @foreach ($subAspeks as $sub)
                                <option value="{{ $sub->id_sub_aspek }}">
                                    {{ $sub->kode_sub_aspek }}. {{ $sub->nama_sub_aspek }}
                                </option>
                            @endforeach
                        </select>
                        @error('sub_aspek_id')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                {{-- Kelompok Usia --}}
                <div>
                    <x-label for="kelompok_usia" value="Kelompok Usia" />
                    <select id="kelompok_usia" wire:model.live="kelompok_usia"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">-- Pilih kelompok usia --</option>
                        @foreach ($kelompokUsiaOptions as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('kelompok_usia')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Kode Indikator --}}
                <div>
                    <x-label for="kode_indikator" value="Kode Indikator" />
                    @if (count($suggestedCodes) > 0)
                        <select id="kode_indikator" wire:model.defer="kode_indikator"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">-- Pilih kode --</option>
                            @foreach ($suggestedCodes as $code)
                                <option value="{{ $code }}">{{ $code }}</option>
                            @endforeach
                        </select>
                    @else
                        <x-input id="kode_indikator" wire:model.defer="kode_indikator" class="mt-1 block w-full"
                            placeholder="Masukkan kode manual" />
                    @endif
                    @error('kode_indikator')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Deskripsi Indikator --}}
            <div class="mt-4">
                <x-label for="deskripsi_indikator" value="Deskripsi Indikator" />
                <textarea id="deskripsi_indikator" wire:model.defer="deskripsi_indikator"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    rows="3" placeholder="Contoh: Berusaha meniru gerakan doa"></textarea>
                @error('deskripsi_indikator')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Preview --}}
            @if ($aspek_id && $kelompok_usia)
                <div class="mt-4 p-3 bg-gray-50 rounded-md">
                    <small class="text-gray-600">
                        <strong>Preview:</strong><br>
                        Aspek: {{ collect($aspeks)->firstWhere('id_aspek', $aspek_id)->kode_aspek ?? '' }}.
                        {{ collect($aspeks)->firstWhere('id_aspek', $aspek_id)->nama_aspek ?? '' }}<br>
                        @if ($sub_aspek_id)
                            Sub Aspek:
                            {{ collect($subAspeks)->firstWhere('id_sub_aspek', $sub_aspek_id)->kode_sub_aspek ?? '' }}.
                            {{ collect($subAspeks)->firstWhere('id_sub_aspek', $sub_aspek_id)->nama_sub_aspek ?? '' }}<br>
                        @endif
                        Kelompok Usia: {{ $kelompokUsiaOptions[$kelompok_usia] ?? '' }}<br>
                        @if ($kode_indikator)
                            Kode: {{ $kode_indikator }}
                        @endif
                    </small>
                </div>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="save" :disabled="!$aspek_id || !$kelompok_usia || !$kode_indikator || !$deskripsi_indikator">
                Simpan
            </x-button>
            <x-secondary-button wire:click="$set('open', false)" class="ml-2">Batal</x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
