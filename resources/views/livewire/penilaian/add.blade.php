<div>
    <x-button wire:click="$set('open', true)">
        Tambah Penilaian
    </x-button>

    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            Tambah Penilaian
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <x-label for="id_akunsiswa" value="Akun Siswa ID" />
                    <x-input id="id_akunsiswa" type="text" class="mt-1 block w-full" wire:model.defer="id_akunsiswa" />
                    @error('id_akunsiswa')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="id_kelas" value="Kelas ID" />
                    <x-input id="id_kelas" type="text" class="mt-1 block w-full" wire:model.defer="id_kelas" />
                    @error('id_kelas')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="tgl_penilaian" value="Tanggal Penilaian" />
                    <x-input id="tgl_penilaian" type="date" class="mt-1 block w-full"
                        wire:model.defer="tgl_penilaian" />
                    @error('tgl_penilaian')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="minggu_ke" value="Minggu Ke" />
                    <x-input id="minggu_ke" type="number" min="1" max="20" class="mt-1 block w-full"
                        wire:model.defer="minggu_ke" />
                    @error('minggu_ke')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="semester" value="Semester" />
                    <select id="semester" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        wire:model.defer="semester">
                        <option value="1">Semester 1</option>
                        <option value="2">Semester 2</option>
                    </select>
                    @error('semester')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="tahun_ajaran" value="Tahun Ajaran" />
                    <x-input id="tahun_ajaran" type="text" class="mt-1 block w-full"
                        wire:model.defer="tahun_ajaran" />
                    @error('tahun_ajaran')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="kelompok_usia_siswa" value="Kelompok Usia Siswa" />
                    <select id="kelompok_usia_siswa" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        wire:model.defer="kelompok_usia_siswa">
                        <option value="2-3_tahun">2-3 Tahun</option>
                        <option value="3-4_tahun">3-4 Tahun</option>
                        <option value="4-5_tahun">4-5 Tahun</option>
                        <option value="5-6_tahun">5-6 Tahun</option>
                    </select>
                    @error('kelompok_usia_siswa')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="save">
                Simpan
            </x-button>

            <x-secondary-button wire:click="$set('open', false)" class="ml-2">
                Batal
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
