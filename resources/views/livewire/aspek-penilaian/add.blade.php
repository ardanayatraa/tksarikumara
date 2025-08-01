<div>
    <x-button wire:click="$set('open', true)">Tambah Indikator Aspek</x-button>

    <x-dialog-modal wire:model="open">
        <x-slot name="title">Tambah Indikator Aspek</x-slot>

        <x-slot name="content">
            {{-- Aspek Utama --}}
            <div class="mb-4">
                <x-label for="aspek_id" value="Aspek Utama" />
                <select id="aspek_id" wire:model.live="aspek_id" class="mt-1 block w-full border-gray-300 rounded-md">
                    <option value="">-- Pilih aspek --</option>
                    @foreach ($aspeks as $asp)
                        <option value="{{ $asp->id_aspek }}">
                            {{ $asp->kode_aspek }}. {{ $asp->nama_aspek }}
                        </option>
                    @endforeach
                </select>
                @error('aspek_id')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- Sub Aspek (jika ada) --}}
            @if (count($subAspeks) > 0)
                <div class="mb-4">
                    <x-label for="sub_aspek_id" value="Sub Aspek" />
                    <select id="sub_aspek_id" wire:model.live="sub_aspek_id"
                        class="mt-1 block w-full border-gray-300 rounded-md">
                        <option value="">-- Pilih sub aspek --</option>
                        @foreach ($subAspeks as $sub)
                            <option value="{{ $sub->id_sub_aspek }}">
                                {{ $sub->kode_sub_aspek }}. {{ $sub->nama_sub_aspek }}
                            </option>
                        @endforeach
                    </select>
                    @error('sub_aspek_id')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            @endif

            {{-- Rentang Umur --}}
            <div class="mb-4">
                <x-label for="rentang" value="Rentang Umur" />
                <select id="rentang" wire:model.live="rentang" class="mt-1 block w-full border-gray-300 rounded-md">
                    <option value="">-- Pilih rentang --</option>
                    @foreach ($ranges as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
                @error('rentang')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- Kode Indikator --}}
            <div class="mb-4">
                <x-label for="kode_indikator" value="Kode Indikator" />
                @if (count($suggestedCodes) > 0)
                    <select id="kode_indikator" wire:model.defer="kode_indikator"
                        class="mt-1 block w-full border-gray-300 rounded-md">
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
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- Nama Indikator --}}
            <div class="mb-4">
                <x-label for="nama_indikator" value="Deskripsi Indikator" />
                <textarea id="nama_indikator" wire:model.defer="nama_indikator" class="mt-1 block w-full border-gray-300 rounded-md"
                    rows="3" placeholder="Contoh: Berusaha meniru gerakan doa"></textarea>
                @error('nama_indikator')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- Bobot (opsional, bisa dihapus jika tidak diperlukan) --}}
            <div class="mb-4">
                <x-label for="bobot" value="Bobot (1-10)" />
                <x-input type="number" id="bobot" min="1" max="10" wire:model.defer="bobot"
                    value="5" class="mt-1 block w-full" />
                <small class="text-gray-500">Opsional: Bobot untuk perhitungan nilai</small>
                @error('bobot')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- Preview Kode --}}
            @if ($aspek_id && $rentang)
                <div class="mb-4 p-3 bg-gray-50 rounded-md">
                    <small class="text-gray-600">
                        <strong>Preview:</strong><br>
                        Aspek: {{ collect($aspeks)->firstWhere('id_aspek', $aspek_id)->kode_aspek ?? '' }}.
                        {{ collect($aspeks)->firstWhere('id_aspek', $aspek_id)->nama_aspek ?? '' }}<br>
                        @if ($sub_aspek_id)
                            Sub Aspek:
                            {{ collect($subAspeks)->firstWhere('id_sub_aspek', $sub_aspek_id)->kode_sub_aspek ?? '' }}.
                            {{ collect($subAspeks)->firstWhere('id_sub_aspek', $sub_aspek_id)->nama_sub_aspek ?? '' }}<br>
                        @endif
                        Kelompok Usia: {{ $ranges[$rentang] ?? '' }}
                    </small>
                </div>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="save" :disabled="!$aspek_id || !$rentang || !$kode_indikator || !$nama_indikator">
                Simpan
            </x-button>
            <x-secondary-button wire:click="$set('open', false)" class="ml-2">Batal</x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
