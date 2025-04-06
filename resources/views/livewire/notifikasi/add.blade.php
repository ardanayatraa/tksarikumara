<div>
    <x-button wire:click="$set('open', true)">
        Tambah Notifikasi
    </x-button>

    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            Tambah Notifikasi
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <x-label for="id_akunsiswa" value="Siswa" />
                    <select id="id_akunsiswa" wire:model.defer="id_akunsiswa" class="mt-1 block w-full">
                        <option value="">Pilih Siswa</option>
                        @foreach ($siswa as $s)
                            <option value="{{ $s->id_akunsiswa }}">{{ $s->namaSiswa ?? 'Siswa #' . $s->id_akunsiswa }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_akunsiswa')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="id_penilaian" value="Penilaian" />
                    <select id="id_penilaian" wire:model.defer="id_penilaian" class="mt-1 block w-full">
                        <option value="">Pilih Penilaian</option>
                        @foreach ($penilaians as $p)
                            <option value="{{ $p->id_penilaian }}">Penilaian #{{ $p->id_penilaian }}</option>
                        @endforeach
                    </select>
                    @error('id_penilaian')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="id_guru" value="Guru" />
                    <select id="id_guru" wire:model.defer="id_guru" class="mt-1 block w-full">
                        <option value="">Pilih Guru</option>
                        @foreach ($gurus as $g)
                            <option value="{{ $g->id_guru }}">{{ $g->namaGuru ?? 'Guru #' . $g->id_guru }}</option>
                        @endforeach
                    </select>
                    @error('id_guru')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="tgl_penilaian" value="Tanggal Penilaian" />
                    <x-input type="date" id="tgl_penilaian" wire:model.defer="tgl_penilaian"
                        class="mt-1 block w-full" />
                    @error('tgl_penilaian')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="status_pengiriman" value="Status Pengiriman" />
                    <x-input type="text" id="status_pengiriman" wire:model.defer="status_pengiriman"
                        class="mt-1 block w-full" />
                    @error('status_pengiriman')
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
