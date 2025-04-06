<x-dialog-modal wire:model="open">
    <x-slot name="title">
        Hapus Nilai Siswa
    </x-slot>

    <x-slot name="content">
        <p class="text-gray-600">
            Yakin ingin menghapus nilai siswa ini? Aksi ini akan menghapus data penilaian terkait.
        </p>
    </x-slot>

    <x-slot name="footer">
        <x-danger-button wire:click="destroy">
            Hapus
        </x-danger-button>

        <x-secondary-button wire:click="$set('open', false)" class="ml-2">
            Batal
        </x-secondary-button>
    </x-slot>
</x-dialog-modal>
