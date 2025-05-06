@props(['id'])

<div class="flex space-x-2">
    <button wire:click="edit({{ $id }})" class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
        Edit
    </button>

    <button wire:click="delete({{ $id }})" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">
        Hapus
    </button>
</div>
