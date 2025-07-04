<div>
    <x-dialog-modal wire:model="open" max-width="2xl">
        <x-slot name="title">Edit Nilai Siswa</x-slot>

        <x-slot name="content">
            {{-- Hidden keys --}}
            <input type="hidden" wire:model="id_nilai" />
            <input type="hidden" wire:model="id_penilaian" />
            <input type="hidden" wire:model="id_akunsiswa" />

            {{-- Kelas (disabled) --}}
            <div class="mb-4">
                <x-label value="Kelas" />
                <x-input type="text" :value="$kelasNama" disabled
                    class="mt-1 block w-full bg-gray-100 cursor-not-allowed" />
            </div>

            {{-- Indikator (disabled) --}}
            <div class="mb-4">
                <x-label value="Indikator" />
                <x-input type="text" :value="$indikator->kode_indikator . ' — ' . $indikator->nama_indikator" disabled
                    class="mt-1 block w-full bg-gray-100 cursor-not-allowed" />
            </div>

            {{-- Tanggal Penilaian --}}
            <div class="mb-4">
                <x-label for="tgl_penilaian" value="Tanggal Penilaian" />
                <x-input id="tgl_penilaian" type="date" wire:model.defer="tgl_penilaian"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                @error('tgl_penilaian')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Nilai & Skor --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <x-label for="nilai" value="Nilai" />
                    <select id="nilai" wire:model="nilai"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">— Pilih Nilai —</option>
                        @foreach ($nilaiOptions as $label => $_)
                            <option value="{{ $label }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('nilai')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <x-label for="skor" value="Skor" />
                    <x-input id="skor" type="text" wire:model.defer="skor" disabled
                        class="mt-1 block w-full bg-gray-100 cursor-not-allowed" />
                    @error('skor')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Catatan --}}
            <div class="mb-4">
                <x-label for="catatan" value="Catatan (opsional)" />
                <textarea id="catatan" wire:model.defer="catatan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    rows="3"></textarea>
                @error('catatan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="update">Update</x-button>
            <x-secondary-button wire:click="$set('open', false)" class="ml-2">
                Batal
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
