<div>
    <x-dialog-modal wire:model="open">
        <x-slot name="title">Hapus Sub Aspek?</x-slot>

        <x-slot name="content">
            <p>Anda yakin ingin menghapus sub aspek ini?</p>
            <p class="text-sm text-red-600 mt-2">Sub aspek yang memiliki indikator tidak dapat dihapus.</p>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('open', false)">Batal</x-secondary-button>
            <x-button class="ml-2" wire:click="confirm">Hapus</x-button>
        </x-slot>
    </x-dialog-modal>
</div>
