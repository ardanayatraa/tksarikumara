<div>
    <x-button wire:click="$set('open', true)">
        Tambah Kelas
    </x-button>

    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            Tambah Kelas
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <x-label for="namaKelas" value="Nama Kelas" />
                    <x-input id="namaKelas" type="text" class="mt-1 block w-full" wire:model.defer="namaKelas" />
                    @error('namaKelas')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="tahunAjaran" value="Tahun Ajaran" />
                    <x-input id="tahunAjaran" type="text" class="mt-1 block w-full" wire:model.defer="tahunAjaran"
                        placeholder="contoh: 2024/2025" />
                    @error('tahunAjaran')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="jumlahSiswa" value="Jumlah Siswa" />
                    <x-input id="jumlahSiswa" type="number" class="mt-1 block w-full" wire:model.defer="jumlahSiswa" />
                    @error('jumlahSiswa')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="save">
                Simpan
            </x-button>

            <x-secondary-button wire:click="$set('open', false)" class="ml-2">
                Batal
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
