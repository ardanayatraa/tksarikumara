<div>
    <x-button wire:click="$set('open', true)">
        Tambah Kepala Sekolah
    </x-button>

    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            Tambah Kepala Sekolah
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <x-label for="namaKepalaSekolah" value="Nama Kepala Sekolah" />
                    <x-input id="namaKepalaSekolah" type="text" class="mt-1 block w-full"
                        wire:model.defer="namaKepalaSekolah" />
                    @error('namaKepalaSekolah')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="nip" value="NIP" />
                    <x-input id="nip" type="text" class="mt-1 block w-full" wire:model.defer="nip" />
                    @error('nip')
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
                    <x-label for="notlp" value="Nomor Telepon" />
                    <x-input id="notlp" type="text" class="mt-1 block w-full" wire:model.defer="notlp" />
                    @error('notlp')
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
