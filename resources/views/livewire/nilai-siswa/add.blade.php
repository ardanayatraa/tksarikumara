<div>
    <x-button wire:click="$set('open', true)" class="px-4 py-2 bg-green-500 text-white rounded">
        Tambah Nilai Siswa
    </x-button>

    <x-dialog-modal wire:model="open" max-width="2xl">
        <x-slot name="title">Tambah Nilai Siswa</x-slot>

        <x-slot name="content">
            {{-- Hidden --}}
            <input type="hidden" wire:model="id_akunsiswa" />
            <input type="hidden" wire:model="id_guru" />
            <input type="hidden" wire:model="id_kelas" />

            {{-- Kelas --}}
            <div class="mb-4">
                <x-label value="Kelas" />
                <x-input type="text" wire:model="kelasNama" disabled
                    class="mt-1 block w-full bg-gray-100 cursor-not-allowed" />
            </div>

            {{-- Tanggal --}}
            <div class="mb-4">
                <x-label value="Tanggal Penilaian" />
                <x-input type="date" wire:model.defer="tgl_penilaian" class="mt-1 block w-full" />
                @error('tgl_penilaian')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <hr class="my-4">

            {{-- Pilih Indikator --}}
            <div class="mb-4">
                <x-label value="Pilih Indikator" />
                <select wire:model.defer="indikator_aspek_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">— Pilih Indikator —</option>
                    @foreach ($indikatorGroups as $aspectLabel => $group)
                        <optgroup label="{{ $aspectLabel }}">
                            @foreach ($group as $ind)
                                <option value="{{ $ind->id }}">
                                    {{ $ind->kode_indikator }}. {{ $ind->nama_indikator }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                @error('indikator_aspek_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Nilai & Skor --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <x-label value="Nilai" />
                    <select wire:model.live="nilai" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
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
                <textarea wire:model.defer="catatan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" rows="3"></textarea>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="save">Simpan</x-button>
            <x-secondary-button wire:click="$set('open', false)" class="ml-2">
                Batal
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
