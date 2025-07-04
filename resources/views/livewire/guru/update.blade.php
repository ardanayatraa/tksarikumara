<x-dialog-modal wire:model="open">
    <x-slot name="title">Edit Data Guru</x-slot>
    <x-slot name="content">
        <div class="space-y-4">
            {{-- Nama Guru --}}
            <div>
                <x-label for="namaGuru" value="Nama Guru" />
                <x-input id="namaGuru" type="text" wire:model.defer="namaGuru" class="mt-1 block w-full" />
                @error('namaGuru')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- NIP --}}
            <div>
                <x-label for="nip" value="NIP" />
                <x-input id="nip" type="text" wire:model.defer="nip" class="mt-1 block w-full" />
                @error('nip')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Username --}}
            <div>
                <x-label for="username" value="Username" />
                <x-input id="username" type="text" wire:model.defer="username" class="mt-1 block w-full" />
                @error('username')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Kelas --}}
            <div>
                <x-label for="id_kelas" value="Kelas" />
                <select id="id_kelas" wire:model.defer="id_kelas" class="mt-1 block w-full border-gray-300 rounded-md">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id_kelas }}">{{ $k->namaKelas }}</option>
                    @endforeach
                </select>
                @error('id_kelas')
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

            {{-- Jenis Kelamin --}}
            <div>
                <x-label for="jenis_kelamin" value="Jenis Kelamin" />
                <select id="jenis_kelamin" wire:model.defer="jenis_kelamin"
                    class="mt-1 block w-full border-gray-300 rounded-md">
                    <option value="">-- Pilih --</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Nomor Telepon --}}
            <div>
                <x-label for="notlp" value="Nomor Telepon" />
                <x-input id="notlp" type="text" wire:model.defer="notlp" class="mt-1 block w-full" />
                @error('notlp')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Foto --}}
            <div>
                <x-label for="foto" value="Foto Guru (opsional)" />
                <x-input id="foto" type="file" wire:model="foto" accept="image/*" class="mt-1 block w-full" />
                @error('foto')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror

                {{-- Preview --}}
                @if ($foto)
                    <div class="mt-2">
                        <span class="block text-sm">Preview baru:</span>
                        <img src="{{ $foto->temporaryUrl() }}" class="mt-1 h-24 w-24 object-cover rounded-full" />
                    </div>
                @elseif ($fotoPreview)
                    <div class="mt-2">
                        <span class="block text-sm">Foto saat ini:</span>
                        <img src="{{ asset('storage/' . $fotoPreview) }}"
                            class="mt-1 h-24 w-24 object-cover rounded-full" />
                    </div>
                @endif
            </div>
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-button wire:click="update">Update</x-button>
        <x-secondary-button wire:click="$set('open', false)" class="ml-2">Batal</x-secondary-button>
    </x-slot>
</x-dialog-modal>
