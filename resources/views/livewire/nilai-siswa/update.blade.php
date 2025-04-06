<x-dialog-modal wire:model="open">
    <x-slot name="title">
        Edit Nilai Siswa
    </x-slot>

    <x-slot name="content">
        <div class="space-y-4">
            <div>
                <x-label for="id_penilaian" value="ID Penilaian" />
                <x-input id="id_penilaian" type="number" class="mt-1 block w-full" wire:model.defer="id_penilaian" />
                @error('id_penilaian')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-label for="aspek_penilaian" value="Aspek Penilaian" />
                <x-input id="aspek_penilaian" type="text" class="mt-1 block w-full"
                    wire:model.defer="aspek_penilaian" />
                @error('aspek_penilaian')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-label for="kategori" value="Kategori" />
                <x-input id="kategori" type="text" class="mt-1 block w-full" wire:model.defer="kategori" />
                @error('kategori')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-label for="skor" value="Skor" />
                <x-input id="skor" type="number" step="0.01" class="mt-1 block w-full"
                    wire:model.defer="skor" />
                @error('skor')
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
