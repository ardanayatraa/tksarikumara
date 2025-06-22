<div>
    @if (!Route::currentRouteName() == 'dashboard.siswa')
        <x-button wire:click="$set('open',true)">Kirim Email Laporan</x-button>
    @else
        <x-button wire:click="$set('open',true)">Print</x-button>
    @endif

    <x-dialog-modal wire:model="open" max-width="2xl">
        <x-slot name="title">Filter Rentang Tanggal</x-slot>
        <x-slot name="content">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-label for="start" value="Dari tanggal" />
                    <x-input id="start" type="date" wire:model.live="start" />
                    @error('start')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <x-label for="end" value="Sampai tanggal" />
                    <x-input id="end" type="date" wire:model.live="end" />
                    @error('end')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <h3 class="mt-6 font-semibold">Preview Data</h3>
            <div class="overflow-auto max-h-64 mt-2">
                <table class="w-full text-sm border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2 border">Tanggal</th>
                            <th class="p-2 border">Aspek</th>
                            <th class="p-2 border">Kategori</th>
                            <th class="p-2 border">Nilai</th>
                            <th class="p-2 border">Skor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($records as $r)
                            <tr>
                                <td class="p-2 border">{{ \Carbon\Carbon::parse($r['tgl_penilaian'])->format('d M Y') }}
                                </td>
                                <td class="p-2 border">{{ $r['nama_aspek'] }}</td>
                                <td class="p-2 border">{{ $r['kategori'] }}</td>
                                <td class="p-2 border">{{ $r['nilai'] }}</td>
                                <td class="p-2 border">{{ $r['skor'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-2 border text-center text-gray-500">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-slot>

        <x-slot name="footer">
            @if (auth()->guard('guru')->check())
                <x-button wire:click="sendEmail">Kirim Email</x-button>
            @endif

            <x-secondary-button wire:click="downloadReport" class="ml-2">Download PDF</x-secondary-button>
            <x-secondary-button wire:click="$set('open',false)" class="ml-2">Batal</x-secondary-button>
        </x-slot>
    </x-dialog-modal>

    @if (session()->has('success'))
        <div class="mt-2 text-green-600">{{ session('success') }}</div>
    @endif
</div>
