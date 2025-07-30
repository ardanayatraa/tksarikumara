{{-- resources/views/livewire/send-student-report.blade.php --}}
<div>
    <x-button wire:click="$set('open', true)">
        {{ auth()->guard('guru')->check() ? 'Kirim Email Laporan' : 'Print' }}
    </x-button>

    <x-dialog-modal wire:model="open" max-width="2xl">
        <x-slot name="title">
            Filter Rentang Tanggal
        </x-slot>

        <x-slot name="content">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <x-label for="year" value="Tahun" />
                    <select id="year" wire:model.live="year"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @for ($y = 2020; $y <= 2030; $y++)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                    @error('year')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <x-label for="month" value="Bulan" />
                    <select id="month" wire:model.live="month"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach ($months as $monthNum => $monthName)
                            <option value="{{ $monthNum }}">{{ $monthName }}</option>
                        @endforeach
                    </select>
                    @error('month')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <x-label for="week" value="Minggu ke-" />
                    <select id="week" wire:model.live="week"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach ($weeks as $weekData)
                            <option value="{{ $weekData['number'] }}">{{ $weekData['label'] }}</option>
                        @endforeach
                    </select>
                    @error('week')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            @if (!empty($start) && !empty($end))
                <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                    <p class="text-sm text-blue-800">
                        <strong>Periode terpilih:</strong>
                        {{ $months[$month] ?? '' }} {{ $year }} - Minggu ke-{{ $week }}
                        @if (!empty($start) && !empty($end))
                            <br><small>({{ \Carbon\Carbon::parse($start)->format('d M Y') }} -
                                {{ \Carbon\Carbon::parse($end)->format('d M Y') }})</small>
                        @endif
                    </p>
                </div>
            @endif

            <h3 class="mt-6 font-semibold">Preview Data</h3>
            <div class="overflow-auto max-h-64 mt-2">
                <table class="w-full text-sm border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2 border">Tanggal</th>
                            <th class="p-2 border">Minggu ke-</th>
                            <th class="p-2 border">Aspek</th>
                            <th class="p-2 border">Indikator</th>
                            <th class="p-2 border">Kategori</th>
                            <th class="p-2 border">Nilai</th>
                            <th class="p-2 border">Skor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($records as $r)
                            <tr>
                                <td class="p-2 border">
                                    {{ \Carbon\Carbon::parse($r['tgl_penilaian'])->format('d M Y') }}
                                </td>
                                <td class="p-2 border text-center">{{ $r['minggu_ke'] }}</td>
                                <td class="p-2 border">{{ $r['kode_aspek'] }}. {{ $r['nama_aspek'] }}</td>
                                <td class="p-2 border">{{ $r['kode_indikator'] }}. {{ $r['nama_indikator'] }}</td>
                                <td class="p-2 border">{{ $r['kategori'] }}</td>
                                <td class="p-2 border">{{ $r['nilai'] }}</td>
                                <td class="p-2 border">{{ $r['skor'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-2 border text-center text-gray-500">
                                    Tidak ada data untuk minggu ini
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (is_array($records) && count($records) > 0)
                <div class="mt-4 p-3 bg-green-50 rounded-lg">
                    <p class="text-sm text-green-800">
                        <strong>Total data ditemukan:</strong> {{ count($records) }} record
                    </p>
                </div>
            @endif
        </x-slot>

        <x-slot name="footer">
            @if (auth()->guard('guru')->check())
                @if (empty($records))
                    <x-button disabled>
                        Kirim Email
                    </x-button>
                @else
                    <x-button wire:click="sendEmail">
                        Kirim Email
                    </x-button>
                @endif
            @endif

            @if (empty($records))
                <x-secondary-button disabled class="ml-3">
                    Download PDF
                </x-secondary-button>
            @else
                <x-secondary-button wire:click="downloadReport" class="ml-3">
                    Download PDF
                </x-secondary-button>
            @endif

            <x-secondary-button wire:click="$set('open', false)" class="ml-3">
                {{ __('Cancel') }}
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>

    @if (session()->has('success'))
        <div class="mt-2 text-green-600">{{ session('success') }}</div>
    @endif
</div>
