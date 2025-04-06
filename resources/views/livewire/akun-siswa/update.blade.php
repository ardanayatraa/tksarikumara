<x-dialog-modal wire:model="open">
    <x-slot name="title">Edit Akun Siswa</x-slot>

    <x-slot name="content">
        <div class="space-y-4">
            <div>
                <x-label value="Kelas" />
                <x-input type="text" wire:model.defer="id_kelas" class="w-full" />
                @error('id_kelas')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-label value="NISN" />
                <x-input type="text" wire:model.defer="nisn" class="w-full" />
                @error('nisn')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-label value="Nama Siswa" />
                <x-input type="text" wire:model.defer="namaSiswa" class="w-full" />
                @error('namaSiswa')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-label value="Tanggal Lahir" />
                <x-input type="date" wire:model.defer="tgl_lahir" class="w-full" />
                @error('tgl_lahir')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-label value="Jenis Kelamin" />
                <select wire:model.defer="jenis_kelamin" class="w-full border-gray-300 rounded">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-label value="Alamat" />
                <x-input type="text" wire:model.defer="alamat" class="w-full" />
                @error('alamat')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-label value="Email" />
                <x-input type="email" wire:model.defer="email" class="w-full" />
                @error('email')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-label value="Username" />
                <x-input type="text" wire:model.defer="username" class="w-full" />
                @error('username')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-label value="Password (Opsional)" />
                <x-input type="password" wire:model.defer="password" class="w-full" />
                @error('password')
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
