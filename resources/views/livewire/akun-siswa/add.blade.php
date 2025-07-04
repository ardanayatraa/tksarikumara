<div class="mb-6">

    {{-- Tombol toggle --}}
    <x-button wire:click="$toggle('open')">
        {{ $open ? 'Batal Tambah' : 'Tambah Akun Siswa' }}
    </x-button>

    {{-- Form inline --}}
    @if ($open)
        <form wire:submit.prevent="save" class="mt-4 space-y-4 bg-white p-6 rounded shadow">

            {{-- Kelas --}}
            <div>
                <x-label for="id_kelas" value="Kelas" />
                <select id="id_kelas" wire:model.defer="id_kelas"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($kelasList as $kelas)
                        <option value="{{ $kelas->id_kelas }}">{{ $kelas->namaKelas }}</option>
                    @endforeach
                </select>
                @error('id_kelas')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- NISN --}}
            <div>
                <x-label for="nisn" value="NISN" />
                <x-input id="nisn" wire:model.defer="nisn" class="mt-1 block w-full" />
                @error('nisn')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Nama Siswa --}}
            <div>
                <x-label for="namaSiswa" value="Nama Siswa" />
                <x-input id="namaSiswa" wire:model.defer="namaSiswa" class="mt-1 block w-full" />
                @error('namaSiswa')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Nama Orang Tua --}}
            <div>
                <x-label for="namaOrangTua" value="Nama Orang Tua" />
                <x-input id="namaOrangTua" wire:model.defer="namaOrangTua" class="mt-1 block w-full" />
                @error('namaOrangTua')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Tanggal Lahir --}}
            <div>
                <x-label for="tgl_lahir" value="Tanggal Lahir" />
                <x-input id="tgl_lahir" type="date" wire:model.defer="tgl_lahir" class="mt-1 block w-full" />
                @error('tgl_lahir')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Jenis Kelamin --}}
            <div>
                <x-label for="jenis_kelamin" value="Jenis Kelamin" />
                <select id="jenis_kelamin" wire:model.defer="jenis_kelamin"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">-- Pilih --</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Alamat --}}
            <div>
                <x-label for="alamat" value="Alamat" />
                <x-input id="alamat" wire:model.defer="alamat" class="mt-1 block w-full" />
                @error('alamat')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <x-label for="email" value="Email" />
                <x-input id="email" type="email" wire:model.defer="email" class="mt-1 block w-full" />
                @error('email')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Username --}}
            <div>
                <x-label for="username" value="Username" />
                <x-input id="username" wire:model.defer="username" class="mt-1 block w-full" />
                @error('username')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <x-label for="password" value="Password" />
                <x-input id="password" type="password" wire:model.defer="password" class="mt-1 block w-full" />
                @error('password')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Foto --}}
            <div>
                <x-label for="foto" value="Foto Siswa (opsional)" />
                <x-input id="foto" type="file" wire:model="foto" accept="image/*" class="mt-1 block w-full" />
                @error('foto')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror

                @if ($fotoPreviewUrl)
                    <div class="mt-2">
                        <span class="text-sm font-medium">Preview Foto:</span>
                        <img src="{{ $fotoPreviewUrl }}" class="mt-1 h-24 w-24 rounded-full object-cover" />
                    </div>
                @endif
            </div>

            {{-- Submit --}}
            <div class="pt-4">
                <x-button type="submit">Simpan</x-button>
            </div>

        </form>
    @endif

</div>
