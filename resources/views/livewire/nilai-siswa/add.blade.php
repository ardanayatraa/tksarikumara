<div>
    <x-button wire:click="$set('open', true)" class="px-4 py-2 bg-green-500 text-white rounded">
        Tambah Nilai
    </x-button>

    <x-dialog-modal wire:model="open" max-width="2xl">
        <x-slot name="title">Tambah Nilai Siswa</x-slot>

        <x-slot name="content">
            {{-- Hidden props --}}
            <input type="hidden" wire:model="id_akunsiswa" />
            <input type="hidden" wire:model="indikator_aspek_id" />

            {{-- Tampilkan indikator terpilih --}}
            <div class="mb-4">
                <x-label value="Indikator" />
                <x-input type="text" :value="$indikator->kode_indikator . ' — ' . $indikator->nama_indikator" disabled
                    class="mt-1 block w-full bg-gray-100 cursor-not-allowed" />
            </div>

            {{-- Tanggal Penilaian --}}
            <div class="mb-4">
                <x-label value="Tanggal Penilaian" />
                <x-input type="date" wire:model.defer="tgl_penilaian"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                @error('tgl_penilaian')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Nilai & Skor --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <x-label value="Nilai" />
                    <select wire:model="nilai" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">— Pilih Nilai —</option>
                        @foreach ($nilaiOptions as $label => $val)
                            <option value="{{ $label }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('nilai')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <x-label value="Skor" />
                    <x-input type="text" wire:model="skor" disabled
                        class="mt-1 block w-full bg-gray-100 cursor-not-allowed" />
                </div>
            </div>

            {{-- Catatan --}}
            <div class="mb-4">
                <x-label value="Catatan (opsional)" />
                <textarea wire:model.defer="catatan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="3"></textarea>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="save">Simpan</x-button>
            <x-secondary-button wire:click="$set('open', false')" class="ml-2">
                Batal
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
