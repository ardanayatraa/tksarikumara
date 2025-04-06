<x-dialog-modal wire:model="open">
    <x-slot name="title">
        Hapus Kepala Sekolah
    </x-slot>

    <x-slot name="content">
        <p class="text-gray-600">
            Yakin ingin menghapus data kepala sekolah ini? Tindakan ini nggak bisa dibatalin, bro.
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
