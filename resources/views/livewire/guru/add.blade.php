<!-- resources/views/livewire/guru/add.blade.php -->
<div>
    <x-button wire:click="$set('open', true)">
        Tambah Guru
    </x-button>

    <x-dialog-modal wire:model="open">
        <x-slot name="title">Tambah Guru</x-slot>

        <x-slot name="content">
            <div class="space-y-4">

                <!-- Nama Guru -->
                <div>
                    <x-label for="namaGuru" value="Nama Guru" />
                    <x-input id="namaGuru" type="text" wire:model.defer="namaGuru" class="mt-1 block w-full" />
                    @error('namaGuru')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- NIP -->
                <div>
                    <x-label for="nip" value="NIP" />
                    <x-input id="nip" type="text" wire:model.defer="nip" class="mt-1 block w-full" />
                    @error('nip')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Username -->
                <div>
                    <x-label for="username" value="Username" />
                    <x-input id="username" type="text" wire:model.defer="username" class="mt-1 block w-full" />
                    @error('username')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <x-label for="email" value="Email" />
                    <x-input id="email" type="email" wire:model.defer="email" class="mt-1 block w-full" />
                    @error('email')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Nomor Telepon -->
                <div>
                    <x-label for="notlp" value="Nomor Telepon" />
                    <x-input id="notlp" type="text" wire:model.defer="notlp" class="mt-1 block w-full" />
                    @error('notlp')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <x-label for="jenis_kelamin" value="Jenis Kelamin" />
                    <select id="jenis_kelamin" wire:model.defer="jenis_kelamin"
                        class="mt-1 block w-full border-gray-300 rounded-md">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <x-label for="password" value="Password" />
                    <x-input id="password" type="password" wire:model.defer="password" class="mt-1 block w-full" />
                    @error('password')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Foto -->
                <div>
                    <x-label for="foto" value="Foto Guru" />
                    <x-input id="foto" type="file" wire:model="foto" accept="image/*"
                        class="mt-1 block w-full" />
                    @error('foto')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror

                    <!-- Preview -->
                    @if ($foto)
                        <div class="mt-2">
                            <span class="block text-sm font-medium text-gray-700">Preview:</span>
                            <img src="{{ $foto->temporaryUrl() }}" class="mt-1 h-24 w-24 object-cover rounded-full" />
                        </div>
                    @endif
                </div>

            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="save">Simpan</x-button>
            <x-secondary-button wire:click="$set('open', false)" class="ml-2">Batal</x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
