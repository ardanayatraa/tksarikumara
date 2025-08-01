{{-- File: resources/views/livewire/indikator/delete.blade.php --}}
<div>
    <x-dialog-modal wire:model="open" maxWidth="md">
        <x-slot name="title">Hapus Indikator?</x-slot>

        <x-slot name="content">
            @if ($indikatorData)
                <div class="mb-4 p-3 bg-gray-50 rounded-md">
                    <div class="text-sm text-gray-600">
                        <strong>Indikator yang akan dihapus:</strong><br>
                        <span class="font-medium">{{ $indikatorData->kode_indikator }}</span><br>
                        <span>{{ $indikatorData->deskripsi_indikator }}</span><br>
                        <span class="text-xs">
                            {{ $indikatorData->aspekPenilaian->nama_aspek }}
                            @if ($indikatorData->subAspek)
                                - {{ $indikatorData->subAspek->nama_sub_aspek }}
                            @endif
                            ({{ str_replace('_', ' ', ucwords($indikatorData->kelompok_usia, '_')) }})
                        </span>
                    </div>
                </div>
            @endif

            <p>Anda yakin ingin menghapus indikator ini?</p>
            <p class="text-sm text-red-600 mt-2">Indikator yang sudah digunakan dalam penilaian tidak dapat dihapus.</p>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('open', false)">Batal</x-secondary-button>
            <x-button class="ml-2 bg-red-600 hover:bg-red-700" wire:click="confirm">Hapus</x-button>
        </x-slot>
    </x-dialog-modal>
</div>
