<div>
    <x-dialog-modal wire:model="open">
        <x-slot name="title">Edit Kepala Sekolah</x-slot>

        <x-slot name="content">
            <div class="space-y-4">

                {{-- Nama --}}
                <div>
                    <x-label for="namaKepalaSekolah" value="Nama Kepala Sekolah" />
                    <x-input id="namaKepalaSekolah" type="text" wire:model.defer="namaKepalaSekolah"
                        class="mt-1 block w-full" />
                    @error('namaKepalaSekolah')
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

                {{-- Email --}}
                <div>
                    <x-label for="email" value="Email" />
                    <x-input id="email" type="email" wire:model.defer="email" class="mt-1 block w-full" />
                    @error('email')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- No. Telepon --}}
                <div>
                    <x-label for="notlp" value="Nomor Telepon" />
                    <x-input id="notlp" type="text" wire:model.defer="notlp" class="mt-1 block w-full" />
                    @error('notlp')
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

                {{-- Foto --}}
                <div>
                    <x-label for="foto" value="Foto Kepala Sekolah (opsional)" />
                    <x-input id="foto" type="file" wire:model="foto" accept="image/*"
                        class="mt-1 block w-full" />
                    @error('foto')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror

                    {{-- preview new or existing --}}
                    @if ($foto)
                        <div class="mt-2">
                            <span class="block text-sm">Preview Baru:</span>
                            <img src="{{ $foto->temporaryUrl() }}" class="mt-1 h-24 w-24 rounded-full object-cover" />
                        </div>
                    @elseif($fotoPreview)
                        <div class="mt-2">
                            <span class="block text-sm">Foto Saat Ini:</span>
                            <img src="{{ asset('storage/' . $fotoPreview) }}"
                                class="mt-1 h-24 w-24 rounded-full object-cover" />
                        </div>
                    @endif
                </div>

            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="update">Update</x-button>
            <x-secondary-button wire:click="$set('open', false')" class="ml-2">Batal</x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
