<x-dialog-modal wire:model="open">
    <x-slot name="title">
        Edit Penilaian
    </x-slot>

    <x-slot name="content">
        <div class="space-y-4">
            <div>
                <x-label for="id_akunsiswa" value="Siswa" />
                <x-input id="id_akunsiswa" type="number" class="mt-1 block w-full" wire:model.defer="id_akunsiswa" />
                @error('id_akunsiswa')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-label for="id_guru" value="Guru" />
                <x-input id="id_guru" type="number" class="mt-1 block w-full" wire:model.defer="id_guru" />
                @error('id_guru')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-label for="tgl_penilaian" value="Tanggal Penilaian" />
                <x-input id="tgl_penilaian" type="date" class="mt-1 block w-full" wire:model.defer="tgl_penilaian" />
                @error('tgl_penilaian')
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
