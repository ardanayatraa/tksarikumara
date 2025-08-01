<div>
    {{-- resources/views/livewire/send-student-report.blade.php --}}
    <div>
        <x-button wire:click="$set('open', true)" class="bg-blue-600 hover:bg-blue-700">
            <i class="fas fa-file-pdf mr-2"></i>
            {{ auth()->guard('guru')->check() ? 'Kirim Email Laporan' : 'Download Laporan' }}
        </x-button>

        <x-dialog-modal wire:model="open" max-width="4xl">
            <x-slot name="title">
                <div class="flex items-center">
                    <i class="fas fa-chart-line text-blue-600 mr-3"></i>
                    Filter Laporan Perkembangan Siswa
                </div>
            </x-slot>

            <x-slot name="content">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div>
                        <x-label for="year" value="Tahun" class="flex items-center">
                            <i class="fas fa-calendar text-gray-500 mr-2"></i>
                            Tahun
                        </x-label>
                        <select id="year" wire:model.live="year"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @for ($y = 2020; $y <= 2030; $y++)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                        @error('year')
                            <span class="text-red-600 text-sm flex items-center mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <x-label for="month" value="Bulan" class="flex items-center">
                            <i class="fas fa-calendar-alt text-gray-500 mr-2"></i>
                            Bulan
                        </x-label>
                        <select id="month" wire:model.live="month"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach ($months as $monthNum => $monthName)
                                <option value="{{ $monthNum }}">{{ $monthName }}</option>
                            @endforeach
                        </select>
                        @error('month')
                            <span class="text-red-600 text-sm flex items-center mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <x-label for="week" value="Minggu ke-" class="flex items-center">
                            <i class="fas fa-clock text-gray-500 mr-2"></i>
                            Minggu ke-
                        </x-label>
                        <select id="week" wire:model.live="week"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach ($weeks as $weekData)
                                <option value="{{ $weekData['number'] }}">{{ $weekData['label'] }}</option>
                            @endforeach
                        </select>
                        @error('week')
                            <span class="text-red-600 text-sm flex items-center mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                {{-- Informasi Periode --}}
                @if (!empty($start) && !empty($end))
                    <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-semibold text-blue-800 flex items-center">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Periode Laporan
                                </h4>
                                <p class="text-sm text-blue-700 mt-1">
                                    <strong>Tahun Ajaran:</strong> {{ $tahunAjaran }} - Semester
                                    {{ $semester }}<br>
                                    <strong>Periode:</strong> {{ $months[$month] ?? '' }} {{ $year }} - Minggu
                                    ke-{{ $week }}<br>
                                    <small class="text-blue-600">
                                        ({{ \Carbon\Carbon::parse($start)->format('d M Y') }} -
                                        {{ \Carbon\Carbon::parse($end)->format('d M Y') }})
                                    </small>
                                </p>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-blue-600">{{ count($records) }}</div>
                                <div class="text-sm text-blue-700">Data Penilaian</div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Rekap Aspek Penilaian --}}
                @if (!empty($rekap))
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-chart-pie text-green-600 mr-2"></i>
                            Ringkasan per Aspek Penilaian
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($rekap as $r)
                                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                                    <div class="flex items-center justify-between mb-2">
                                        <h5 class="font-semibold text-gray-800">{{ $r['kode_aspek'] }}</h5>
                                        <span
                                            class="px-2 py-1 rounded-full text-xs font-medium
                                        {{ $r['status_color'] === 'success'
                                            ? 'bg-green-100 text-green-800'
                                            : ($r['status_color'] === 'info'
                                                ? 'bg-blue-100 text-blue-800'
                                                : ($r['status_color'] === 'warning'
                                                    ? 'bg-yellow-100 text-yellow-800'
                                                    : 'bg-red-100 text-red-800')) }}">
                                            {{ $r['status_perkembangan'] }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-2">{{ Str::limit($r['nama_aspek'], 40) }}</p>
                                    <div class="flex items-center justify-between text-sm">
                                        <span>Skor Rata-rata:</span>
                                        <span class="font-semibold text-blue-600">{{ $r['skor_rata'] }}/4</span>
                                    </div>
                                    <div class="mt-2 text-xs text-gray-500">
                                        {{ $r['jumlah_nilai'] }} indikator dinilai
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Preview Data Detail --}}
                <div class="mb-4">
                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-list-alt text-purple-600 mr-2"></i>
                        Detail Data Penilaian
                    </h4>
                    <div class="overflow-auto max-h-64 border border-gray-200 rounded-lg">
                        <table class="w-full text-sm border-collapse">
                            <thead class="bg-gray-50 sticky top-0">
                                <tr>
                                    <th class="p-3 border-b text-left font-medium text-gray-700">Tanggal</th>
                                    <th class="p-3 border-b text-left font-medium text-gray-700">Aspek</th>
                                    <th class="p-3 border-b text-left font-medium text-gray-700">Sub Aspek</th>
                                    <th class="p-3 border-b text-left font-medium text-gray-700">Indikator</th>
                                    <th class="p-3 border-b text-left font-medium text-gray-700">Kelompok Usia</th>
                                    <th class="p-3 border-b text-center font-medium text-gray-700">Nilai</th>
                                    <th class="p-3 border-b text-center font-medium text-gray-700">Skor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($records as $r)
                                    <tr class="hover:bg-gray-50">
                                        <td class="p-3 border-b">
                                            {{ \Carbon\Carbon::parse($r['tgl_penilaian'])->format('d M Y') }}
                                        </td>
                                        <td class="p-3 border-b">
                                            <div class="flex items-center">
                                                <span
                                                    class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-semibold mr-2">
                                                    {{ $r['kode_aspek'] }}
                                                </span>
                                                <span class="text-sm">{{ Str::limit($r['nama_aspek'], 25) }}</span>
                                            </div>
                                        </td>
                                        <td class="p-3 border-b">
                                            @if ($r['kode_sub_aspek'])
                                                <span
                                                    class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs font-semibold">
                                                    {{ $r['kode_sub_aspek'] }}
                                                </span>
                                                <div class="text-xs text-gray-500 mt-1">
                                                    {{ Str::limit($r['nama_sub_aspek'], 20) }}</div>
                                            @else
                                                <span class="text-gray-400 text-xs">-</span>
                                            @endif
                                        </td>
                                        <td class="p-3 border-b">
                                            <div class="flex items-start">
                                                <span
                                                    class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold mr-2">
                                                    {{ $r['kode_indikator'] }}
                                                </span>
                                                <span class="text-sm">{{ Str::limit($r['nama_indikator'], 30) }}</span>
                                            </div>
                                        </td>
                                        <td class="p-3 border-b text-center">
                                            <span
                                                class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-semibold">
                                                {{ str_replace('_', ' ', $r['kelompok_usia']) }}
                                            </span>
                                        </td>
                                        <td class="p-3 border-b text-center">
                                            <span
                                                class="px-2 py-1 rounded text-xs font-semibold
                                            {{ $r['nilai'] === 'BSB'
                                                ? 'bg-green-100 text-green-800'
                                                : ($r['nilai'] === 'BSH'
                                                    ? 'bg-blue-100 text-blue-800'
                                                    : ($r['nilai'] === 'MB'
                                                        ? 'bg-yellow-100 text-yellow-800'
                                                        : 'bg-red-100 text-red-800')) }}">
                                                {{ $r['nilai'] }}
                                            </span>
                                        </td>
                                        <td class="p-3 border-b text-center font-semibold">
                                            {{ $r['skor'] }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="p-8 text-center text-gray-500">
                                            <div class="flex flex-col items-center">
                                                <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                                                <p class="text-sm">Tidak ada data penilaian untuk periode ini</p>
                                                <p class="text-xs text-gray-400 mt-1">Silakan pilih periode lain atau
                                                    pastikan data sudah diinput</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Summary Statistik --}}
                @if (is_array($records) && count($records) > 0)
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-4 bg-gray-50 rounded-lg">
                        @php
                            $totalRecords = count($records);
                            $nilaiCounts = [
                                'BSB' => collect($records)->where('nilai', 'BSB')->count(),
                                'BSH' => collect($records)->where('nilai', 'BSH')->count(),
                                'MB' => collect($records)->where('nilai', 'MB')->count(),
                                'BB' => collect($records)->where('nilai', 'BB')->count(),
                            ];
                        @endphp

                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $nilaiCounts['BSB'] }}</div>
                            <div class="text-xs text-gray-600">BSB - Berkembang Sangat Baik</div>
                            <div class="text-xs text-gray-500">
                                {{ $totalRecords > 0 ? round(($nilaiCounts['BSB'] / $totalRecords) * 100, 1) : 0 }}%
                            </div>
                        </div>

                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $nilaiCounts['BSH'] }}</div>
                            <div class="text-xs text-gray-600">BSH - Berkembang Sesuai Harapan</div>
                            <div class="text-xs text-gray-500">
                                {{ $totalRecords > 0 ? round(($nilaiCounts['BSH'] / $totalRecords) * 100, 1) : 0 }}%
                            </div>
                        </div>

                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-600">{{ $nilaiCounts['MB'] }}</div>
                            <div class="text-xs text-gray-600">MB - Mulai Berkembang</div>
                            <div class="text-xs text-gray-500">
                                {{ $totalRecords > 0 ? round(($nilaiCounts['MB'] / $totalRecords) * 100, 1) : 0 }}%
                            </div>
                        </div>

                        <div class="text-center">
                            <div class="text-2xl font-bold text-red-600">{{ $nilaiCounts['BB'] }}</div>
                            <div class="text-xs text-gray-600">BB - Belum Berkembang</div>
                            <div class="text-xs text-gray-500">
                                {{ $totalRecords > 0 ? round(($nilaiCounts['BB'] / $totalRecords) * 100, 1) : 0 }}%
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 p-3 bg-green-50 rounded-lg border border-green-200">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-600 mr-2"></i>
                            <div>
                                <p class="text-sm text-green-800 font-medium">
                                    Total data ditemukan: {{ $totalRecords }} penilaian
                                </p>
                                <p class="text-xs text-green-700">
                                    Mencakup {{ count($rekap) }} aspek perkembangan
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </x-slot>

            <x-slot name="footer">
                <div class="flex items-center justify-between w-full">
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-2"></i>
                        <span>Laporan akan mencakup semua data periode terpilih</span>
                    </div>

                    <div class="flex items-center space-x-3">
                        {{-- Tombol Email (hanya untuk guru) --}}
                        @if (auth()->guard('guru')->check())
                            @if (empty($records))
                                <x-button disabled class="bg-gray-400">
                                    <i class="fas fa-envelope mr-2"></i>
                                    Kirim Email
                                </x-button>
                            @else
                                <x-button wire:click="sendEmail" class="bg-green-600 hover:bg-green-700">
                                    <i class="fas fa-envelope mr-2"></i>
                                    Kirim Email
                                </x-button>
                            @endif
                        @endif

                        {{-- Tombol Download PDF --}}
                        @if (empty($records))
                            <x-secondary-button disabled class="bg-gray-100 text-gray-400">
                                <i class="fas fa-file-pdf mr-2"></i>
                                Download PDF
                            </x-secondary-button>
                        @else
                            <x-secondary-button wire:click="downloadReport"
                                class="bg-red-600 text-white hover:bg-red-700">
                                <i class="fas fa-file-pdf mr-2"></i>
                                Download PDF
                            </x-secondary-button>
                        @endif

                        {{-- Tombol Cancel --}}
                        <x-secondary-button wire:click="$set('open', false)">
                            <i class="fas fa-times mr-2"></i>
                            {{ __('Cancel') }}
                        </x-secondary-button>
                    </div>
                </div>
            </x-slot>
        </x-dialog-modal>

        {{-- Alert Messages --}}
        @if (session()->has('success'))
            <div class="mt-3 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-600 mr-3"></i>
                    <div class="text-green-800">
                        <p class="font-medium">Berhasil!</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mt-3 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-600 mr-3"></i>
                    <div class="text-red-800">
                        <p class="font-medium">Terjadi Kesalahan!</p>
                        <p class="text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Loading States --}}
        <div wire:loading wire:target="loadRecords" class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex items-center">
                <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-600 mr-3"></div>
                <span class="text-blue-800 text-sm">Memuat data penilaian...</span>
            </div>
        </div>

        <div wire:loading wire:target="downloadReport" class="mt-3 p-3 bg-red-50 border border-red-200 rounded-lg">
            <div class="flex items-center">
                <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-red-600 mr-3"></div>
                <span class="text-red-800 text-sm">Menyiapkan laporan PDF...</span>
            </div>
        </div>

        <div wire:loading wire:target="sendEmail" class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-center">
                <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-green-600 mr-3"></div>
                <span class="text-green-800 text-sm">Mengirim email laporan...</span>
            </div>
        </div>
    </div>

    {{-- Font Awesome CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Custom animations */
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Custom scrollbar for table */
        .overflow-auto::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .overflow-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .overflow-auto::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .overflow-auto::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
</div>
