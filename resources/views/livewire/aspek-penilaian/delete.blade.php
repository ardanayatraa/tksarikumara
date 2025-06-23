<div>
    <x-dialog-modal wire:model="open">
        <x-slot name="title">Hapus Indikator Aspek?</x-slot>

        <x-slot name="content">
            <p>Anda yakin ingin menghapus indikator ini?</p>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('open', false)">Batal</x-secondary-button>
            <x-button class="ml-2" wire:click="confirm">Hapus</x-button>
        </x-slot>
    </x-dialog-modal>
</div>
