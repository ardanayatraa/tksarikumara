<div>
    <x-button wire:click="$set('open', true)">
        Tambah Akun Siswa
    </x-button>

    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            Tambah Akun Siswa
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <x-label for="id_kelas" value="Kelas" />
                    <select wire:model.defer="id_kelas" id="id_kelas" class="w-full rounded">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($kelasList as $kelas)
                            <option value="{{ $kelas->id_kelas }}">{{ $kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                    @error('id_kelas')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="nisn" value="NISN" />
                    <x-input id="nisn" type="text" class="mt-1 block w-full" wire:model.defer="nisn" />
                    @error('nisn')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="namaSiswa" value="Nama Siswa" />
                    <x-input id="namaSiswa" type="text" class="mt-1 block w-full" wire:model.defer="namaSiswa" />
                    @error('namaSiswa')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="tgl_lahir" value="Tanggal Lahir" />
                    <x-input id="tgl_lahir" type="date" class="mt-1 block w-full" wire:model.defer="tgl_lahir" />
                    @error('tgl_lahir')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="jenis_kelamin" value="Jenis Kelamin" />
                    <select wire:model.defer="jenis_kelamin" id="jenis_kelamin" class="w-full rounded">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="alamat" value="Alamat" />
                    <x-input id="alamat" type="text" class="mt-1 block w-full" wire:model.defer="alamat" />
                    @error('alamat')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="email" value="Email" />
                    <x-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="email" />
                    @error('email')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="username" value="Username" />
                    <x-input id="username" type="text" class="mt-1 block w-full" wire:model.defer="username" />
                    @error('username')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="password" value="Password" />
                    <x-input id="password" type="password" class="mt-1 block w-full" wire:model.defer="password" />
                    @error('password')
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
