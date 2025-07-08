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

            {{-- Rentang Umur --}}
            <div class="mb-4">
                <x-label for="rentang" value="Rentang Umur" />
                <select id="rentang" wire:model="rentang" class="mt-1 block w-full border-gray-300 rounded-md">
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
                @if (count($suggestedCodes))
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
                <x-label for="nama_indikator" value="Nama Indikator" />
                <x-input id="nama_indikator" wire:model.defer="nama_indikator" class="mt-1 block w-full" />
                @error('nama_indikator')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- Bobot --}}
            <div class="mb-4">
                <x-label for="bobot" value="Bobot (1-10)" />
                <x-input type="number" id="bobot" min="1" max="10" wire:model.defer="bobot"
                    class="mt-1 block w-full" />
                @error('bobot')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="save">Simpan</x-button>
            <x-secondary-button wire:click="$set('open', false)" class="ml-2">Batal</x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
