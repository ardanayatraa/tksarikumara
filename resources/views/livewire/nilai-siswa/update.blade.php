<div>
    <x-dialog-modal wire:model="open" max-width="2xl">
        <x-slot name="title">Edit Penilaian & Nilai</x-slot>

        <x-slot name="content">
            {{-- hidden keys --}}
            <input type="hidden" wire:model="id_nilai" />
            <input type="hidden" wire:model="id_penilaian" />
            <input type="hidden" wire:model="id_akunsiswa" />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Guru --}}
                <div>
                    <x-label for="id_guru" value="Guru" />
                    <select id="id_guru" wire:model.defer="id_guru"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">— Pilih Guru —</option>
                        @foreach ($guruList as $g)
                            <option value="{{ $g->id_guru }}">{{ $g->namaGuru }}</option>
                        @endforeach
                    </select>
                    @error('id_guru')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Kelas --}}
                <div>
                    <x-label for="id_kelas" value="Kelas" />
                    <select id="id_kelas" wire:model.defer="id_kelas"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">— Pilih Kelas —</option>
                        @foreach ($kelasList as $k)
                            <option value="{{ $k->id_kelas }}">{{ $k->namaKelas }}</option>
                        @endforeach
                    </select>
                    @error('id_kelas')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Semester --}}
                <div>
                    <x-label for="id_semester" value="Semester" />
                    <select id="id_semester" wire:model.defer="id_semester"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">— Pilih Semester —</option>
                        @foreach ($semesterList as $sm)
                            <option value="{{ $sm->id }}">{{ $sm->nama_semester }}</option>
                        @endforeach
                    </select>
                    @error('id_semester')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Tanggal --}}
                <div>
                    <x-label for="tgl_penilaian" value="Tanggal Penilaian" />
                    <x-input id="tgl_penilaian" type="date" class="mt-1 block w-full"
                        wire:model.defer="tgl_penilaian" />
                    @error('tgl_penilaian')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <hr class="my-4">

            {{-- Aspek, Nilai & Skor --}}
            <div class="space-y-4">
                <div>
                    <x-label for="id_aspek" value="Aspek Penilaian" />
                    <select id="id_aspek" wire:model.defer="id_aspek"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">— Pilih Aspek —</option>
                        @foreach ($aspeks as $a)
                            <option value="{{ $a->id_aspek }}">{{ $a->nama_aspek }}</option>
                        @endforeach
                    </select>
                    @error('id_aspek')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="nilai" value="Nilai" />
                    <select id="nilai" wire:model.live="nilai"
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300">
                        <option value="">-- Pilih Nilai --</option>
                        <option value="BSB">BSB - Berkembang Sangat Baik</option>
                        <option value="BSH">BSH - Berkembang Sesuai Harapan</option>
                        <option value="MB">MB - Mulai Berkembang</option>
                        <option value="BB">BB - Belum Berkembang</option>
                    </select>
                    @error('nilai')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>


                <div>
                    <x-label for="skor" value="Skor" />
                    <x-input id="skor" type="text" disabled wire:model.defer="skor" class="mt-1 block w-full" />
                    @error('skor')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="update">Update</x-button>
            <x-secondary-button wire:click="$set('open', false)" class="ml-2">Batal</x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
