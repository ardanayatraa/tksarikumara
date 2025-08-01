<div>
    <x-dialog-modal wire:model="open">
        <x-slot name="title">Edit Sub Aspek</x-slot>

        <x-slot name="content">
            {{-- Aspek Utama --}}
            <div class="mb-4">
                <x-label for="aspek_id" value="Aspek Utama" />
                <select id="aspek_id" wire:model="aspek_id" class="mt-1 block w-full border-gray-300 rounded-md">
                    <option value="">-- Pilih aspek --</option>
                    @foreach ($aspeks as $aspek)
                        <option value="{{ $aspek->id_aspek }}">
                            {{ $aspek->kode_aspek }}. {{ $aspek->nama_aspek }}
                        </option>
                    @endforeach
                </select>
                @error('aspek_id')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- Kode Sub Aspek --}}
            <div class="mb-4">
                <x-label for="kode_sub_aspek" value="Kode Sub Aspek" />
                <x-input id="kode_sub_aspek" wire:model.defer="kode_sub_aspek" class="mt-1 block w-full" />
                @error('kode_sub_aspek')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- Nama Sub Aspek --}}
            <div class="mb-4">
                <x-label for="nama_sub_aspek" value="Nama Sub Aspek" />
                <x-input id="nama_sub_aspek" wire:model.defer="nama_sub_aspek" class="mt-1 block w-full" />
                @error('nama_sub_aspek')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div class="mb-4">
                <x-label for="deskripsi" value="Deskripsi (Opsional)" />
                <textarea id="deskripsi" wire:model.defer="deskripsi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    rows="3"></textarea>
                @error('deskripsi')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="update">Simpan Perubahan</x-button>
            <x-secondary-button wire:click="$set('open', false)" class="ml-2">Batal</x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
