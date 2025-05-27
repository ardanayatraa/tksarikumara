<div>
    <x-button wire:click="$set('open', true)">
        Tambah Nilai Siswa
    </x-button>

    <x-dialog-modal wire:model="open" max-width="2xl">
        <x-slot name="title">Tambah Nilai Siswa</x-slot>
        <x-slot name="content">
            {{-- hidden keys --}}
            <input type="hidden" wire:model="id_akunsiswa" />
            <input type="hidden" wire:model="id_guru" />
            <input type="hidden" wire:model="id_kelas" />

            {{-- Tampilkan Kelas otomatis --}}
            <div class="mb-4">
                <x-label for="kelas" value="Kelas" />
                <x-input id="kelas" type="text" wire:model="kelasNama" disabled
                    class="mt-1 block w-full bg-gray-100 cursor-not-allowed" />
            </div>

            {{-- Pilih Tanggal --}}
            <div class="mb-4">
                <x-label for="tgl_penilaian" value="Tanggal Penilaian" />
                <x-input id="tgl_penilaian" type="date" wire:model.defer="tgl_penilaian" class="mt-1 block w-full" />
                @error('tgl_penilaian')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <hr class="my-4">

            {{-- Pilih Aspek --}}
            <div class="space-y-4">
                <div>
                    <x-label for="id_aspek" value="Aspek Penilaian" />
                    <select id="id_aspek" wire:model.defer="id_aspek"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">— Pilih Aspek —</option>
                        @foreach ($aspekGroups as $parent)
                            <optgroup label="{{ $parent->kode_aspek }}. {{ $parent->nama_aspek }}">
                                @forelse($parent->children as $child)
                                    <option value="{{ $child->id_aspek }}">
                                        {{ $child->kode_aspek }}. {{ $child->nama_aspek }}
                                    </option>
                                @empty
                                    <option value="{{ $parent->id_aspek }}">
                                        {{ $parent->kode_aspek }}. {{ $parent->nama_aspek }}
                                    </option>
                                @endforelse
                            </optgroup>
                        @endforeach
                    </select>
                    @error('id_aspek')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Pilih Nilai & Tampilkan Skor --}}
                <div>
                    <x-label for="nilai" value="Nilai" />
                    <select id="nilai" wire:model.live="nilai"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">— Pilih Nilai —</option>
                        <option value="BSB">BSB - Berkembang Sangat Baik</option>
                        <option value="BSH">BSH - Berkembang Sesuai Harapan</option>
                        <option value="MB">MB - Mulai Berkembang</option>
                        <option value="BB">BB - Belum Berkembang</option>
                    </select>
                    @error('nilai')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="skor" value="Skor" />
                    <x-input id="skor" type="text" disabled wire:model.defer="skor"
                        class="mt-1 block w-full bg-gray-100 cursor-not-allowed" />
                    @error('skor')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="save">Simpan</x-button>
            <x-secondary-button wire:click="$set('open', false')" class="ml-2">Batal</x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
