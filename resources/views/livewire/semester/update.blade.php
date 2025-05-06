<x-dialog-modal wire:model="open">
    <x-slot name="title">
        Edit Semester
    </x-slot>

    <x-slot name="content">
        <div class="space-y-4">
            {{-- Nama Semester --}}
            <div>
                <x-label for="nama_semester" value="Nama Semester" />
                <x-input id="nama_semester" type="text" class="mt-1 block w-full" wire:model.defer="nama_semester" />
                @error('nama_semester')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- Tahun Awal --}}
            <div>
                <x-label for="tahun_awal" value="Tahun Awal" />
                <x-input id="tahun_awal" type="number" class="mt-1 block w-full" wire:model.defer="tahun_awal" />
                @error('tahun_awal')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- Tahun Akhir --}}
            <div>
                <x-label for="tahun_akhir" value="Tahun Akhir" />
                <x-input id="tahun_akhir" type="number" class="mt-1 block w-full" wire:model.defer="tahun_akhir" />
                @error('tahun_akhir')
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
