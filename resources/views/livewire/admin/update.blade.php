<x-dialog-modal wire:model="open">
    <x-slot name="title">
        Edit Admin
    </x-slot>

    <x-slot name="content">
        <div class="space-y-4">
            <div>
                <x-label for="username" value="Username" />
                <x-input id="username" type="text" class="mt-1 block w-full" wire:model.defer="username" />
                @error('username')
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
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-button wire:click="update">
            Update
        </x-button>

        <x-secondary-button wire:click="$set('open', false)" class="ml-2">
            Batal
        </x-secondary-button>
    </x-slot>
</x-dialog-modal>
