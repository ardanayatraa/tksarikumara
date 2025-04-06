<x-dialog-modal wire:model="open">
    <x-slot name="title">
        Edit Notifikasi
    </x-slot>

    <x-slot name="content">
        <div class="space-y-4">
            <div>
                <x-label for="id_akunsiswa" value="ID Akun Siswa" />
                <x-input id="id_akunsiswa" type="number" class="mt-1 block w-full" wire:model.defer="id_akunsiswa" />
                @error('id_akunsiswa')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-label for="id_penilaian" value="ID Penilaian" />
                <x-input id="id_penilaian" type="number" class="mt-1 block w-full" wire:model.defer="id_penilaian" />
                @error('id_penilaian')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-label for="id_guru" value="ID Guru" />
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

            <div>
                <x-label for="status_pengiriman" value="Status Pengiriman" />
                <x-input id="status_pengiriman" type="text" class="mt-1 block w-full"
                    wire:model.defer="status_pengiriman" />
                @error('status_pengiriman')
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
