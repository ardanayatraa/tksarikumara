<div>
    <x-button wire:click="$set('open', true)">Tambah Aspek Penilaian</x-button>

    <x-dialog-modal wire:model="open">
        <x-slot name="title">Tambah Aspek Penilaian</x-slot>

        <x-slot name="content">
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

            {{-- Parent (root) --}}
            <div class="mb-4">
                <x-label for="parent_id" value="Parent (opsional)" />
                <select id="parent_id" wire:model.live="parent_id" class="mt-1 block w-full border-gray-300 rounded-md">
                    <option value="">-- Root --</option>
                    @foreach ($parents as $p)
                        <option value="{{ $p->id_aspek }}">
                            {{ $p->kode_aspek }}. {{ $p->nama_aspek }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- Kode Aspek --}}
            <div class="mb-4">
                <x-label for="kode_aspek" value="Kode Aspek" />
                @if (count($suggestedCodes))
                    {{-- jika ada parent, pakai dropdown saran --}}
                    <select id="kode_aspek" wire:model.defer="kode_aspek"
                        class="mt-1 block w-full border-gray-300 rounded-md">
                        <option value="">-- Pilih kode child --</option>
                        @foreach ($suggestedCodes as $code)
                            <option value="{{ $code }}">{{ $code }}</option>
                        @endforeach
                    </select>
                @else
                    {{-- default input bebas --}}
                    <x-input id="kode_aspek" wire:model.defer="kode_aspek" class="mt-1 block w-full" />
                @endif
                @error('kode_aspek')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- Nama Aspek --}}
            <div class="mb-4">
                <x-label for="nama_aspek" value="Nama Aspek" />
                <x-input id="nama_aspek" wire:model.defer="nama_aspek" class="mt-1 block w-full" />
                @error('nama_aspek')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- Kategori --}}
            <div class="mb-4">
                <x-label for="kategori" value="Kategori" />
                <x-input id="kategori" wire:model.defer="kategori" class="mt-1 block w-full" />
                @error('kategori')
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
