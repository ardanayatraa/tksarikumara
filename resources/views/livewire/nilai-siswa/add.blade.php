<div>
    <x-button wire:click="$set('open', true)">
        Tambah Nilai Siswa
    </x-button>

    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            Tambah Nilai Siswa
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <x-label for="id_penilaian" value="Penilaian" />
                    <select id="id_penilaian" wire:model.defer="id_penilaian"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">Pilih Penilaian</option>
                        @foreach ($penilaians as $penilaian)
                            <option value="{{ $penilaian->id_penilaian }}">
                                {{ $penilaian->id_penilaian }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_penilaian')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="aspek_penilaian" value="Aspek Penilaian" />
                    <x-input id="aspek_penilaian" type="text" class="mt-1 block w-full"
                        wire:model.defer="aspek_penilaian" />
                    @error('aspek_penilaian')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="kategori" value="Kategori" />
                    <x-input id="kategori" type="text" class="mt-1 block w-full" wire:model.defer="kategori" />
                    @error('kategori')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label for="skor" value="Skor" />
                    <x-input id="skor" type="number" step="0.01" class="mt-1 block w-full"
                        wire:model.defer="skor" />
                    @error('skor')
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
