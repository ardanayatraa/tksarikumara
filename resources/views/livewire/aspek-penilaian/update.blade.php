<x-dialog-modal wire:model="open">
    <x-slot name="title">
        Edit Aspek Penilaian
    </x-slot>

    <x-slot name="content">
        <div class="space-y-4">
            {{-- Kode Aspek --}}
            <div>
                <x-label for="kode_aspek" value="Kode Aspek" />
                <x-input id="kode_aspek" type="text" class="mt-1 block w-full" wire:model.defer="kode_aspek" />
                @error('kode_aspek')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- Nama Aspek --}}
            <div>
                <x-label for="nama_aspek" value="Nama Aspek" />
                <x-input id="nama_aspek" type="text" class="mt-1 block w-full" wire:model.defer="nama_aspek" />
                @error('nama_aspek')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- Kategori --}}
            <div>
                <x-label for="kategori" value="Kategori" />
                <x-input id="kategori" type="text" class="mt-1 block w-full" wire:model.defer="kategori" />
                @error('kategori')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-button wire:click="update">
            Update
        </x-button>
        <x-secondary-button wire:click="$set('open', false)" class="ml-2">
            Batal
        </x-secondary-button>
    </x-slot>
</x-dialog-modal>
