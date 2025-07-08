<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-teal-50">
    {{-- Alert Messages --}}
    @if ($showAlert)
        <div x-data="{ show: @entangle('showAlert') }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-2" class="fixed top-4 right-4 z-50 max-w-md">
            <div
                class="rounded-lg shadow-lg p-4 {{ $alertType == 'success' ? 'bg-gradient-to-r from-green-400 to-green-600 text-white' : 'bg-gradient-to-r from-red-400 to-red-600 text-white' }}">
                <div class="flex items-center">
                    @if ($alertType == 'success')
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @else
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @endif
                    <span class="font-medium">{{ $alertMessage }}</span>
                </div>
            </div>
        </div>
    @endif

    <div class="container mx-auto px-4 py-6">
        {{-- Header --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-6">
            <div class="bg-green-500 p-6 text-white">
                <h2 class="text-2xl font-bold mb-2"># Penilaian Individu Per Minggu dalam jangka waktu 1 Semester</h2>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <div class="flex">
                            <span class="w-28 font-semibold text-gray-700">Nama Siswa</span>
                            <span class="mx-2">:</span>
                            <span class="text-gray-900">{{ $siswa->namaSiswa }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-28 font-semibold text-gray-700">Usia</span>
                            <span class="mx-2">:</span>
                            <span class="text-gray-900">
                                @if ($siswa->tgl_lahir)
                                    {{ \Carbon\Carbon::parse($siswa->tgl_lahir)->age }} Tahun
                                @else
                                    -
                                @endif
                            </span>
                        </div>
                        <div class="flex">
                            <span class="w-28 font-semibold text-gray-700">Kelas</span>
                            <span class="mx-2">:</span>
                            <span class="text-gray-900">{{ $siswa->kelas->namaKelas ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex">
                            <span class="w-28 font-semibold text-gray-700">Tahun Ajaran</span>
                            <span class="mx-2">:</span>
                            <span class="text-gray-900">{{ $tahunAjaran }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-28 font-semibold text-gray-700">Nama Guru</span>
                            <span class="mx-2">:</span>
                            <span class="text-gray-900">{{ Auth::user()->name ?? 'Guru Satu' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Penilaian --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-800">Hasil Penilaian</h3>
                    @if (!$viewOnly)
                        <button wire:click="simpanSemua" wire:loading.attr="disabled"
                            class="px-4 py-2 bg-gradient-to-r from-teal-500 to-blue-600 text-white rounded-lg hover:from-teal-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-200 flex items-center disabled:opacity-50">
                            <svg wire:loading.remove wire:target="simpanSemua" class="w-5 h-5 mr-2" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                                </path>
                            </svg>
                            <svg wire:loading wire:target="simpanSemua" class="animate-spin h-5 w-5 mr-2" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span wire:loading.remove wire:target="simpanSemua">Simpan Semua</span>
                            <span wire:loading wire:target="simpanSemua">Menyimpan...</span>
                        </button>
                    @endif
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th rowspan="2"
                                class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-b border-gray-300">
                                No
                            </th>
                            <th rowspan="2"
                                class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-b border-gray-300">
                                Kode<br>Aspek
                            </th>
                            <th rowspan="2"
                                class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-b border-gray-300">
                                Aspek Penilaian
                            </th>
                            <th rowspan="2"
                                class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-b border-gray-300 min-w-[250px]">
                                Indikator
                            </th>
                            <th colspan="20"
                                class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-b border-gray-300">
                                Minggu Ke
                            </th>
                            <th rowspan="2"
                                class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-b border-gray-300">
                                Jumlah-<br>Nilai
                            </th>
                        </tr>
                        <tr class="bg-gray-100">
                            @for ($i = 1; $i <= 20; $i++)
                                <th
                                    class="px-2 py-2 text-center text-xs font-medium text-gray-700 border-r border-b border-gray-300 min-w-[40px]">
                                    {{ $i }}
                                </th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php $no = 1; @endphp
                        @foreach ($aspekList as $aspek)
                            @foreach ($aspek->indikator as $indIndex => $indikator)
                                <tr class="hover:bg-gray-50 {{ $indIndex == 0 ? 'border-t-2 border-gray-600' : '' }}">
                                    @if ($indIndex == 0)
                                        <td rowspan="{{ $aspek->indikator->count() }}"
                                            class="px-4 py-3 text-center text-sm font-medium text-gray-900 border-r border-gray-300">
                                            {{ $no++ }}
                                        </td>
                                        <td rowspan="{{ $aspek->indikator->count() }}"
                                            class="px-4 py-3 text-center text-sm font-medium text-gray-900 border-r border-gray-300">
                                            {{ $aspek->kode_aspek }}
                                        </td>
                                        <td rowspan="{{ $aspek->indikator->count() }}"
                                            class="px-4 py-3 text-sm font-medium text-gray-900 border-r border-gray-300">
                                            {{ $aspek->nama_aspek }}
                                        </td>
                                    @endif

                                    <td class="px-4 py-3 text-sm text-gray-700 border-r border-gray-300">
                                        <div class="flex items-start">
                                            <span class="mr-2">•</span>
                                            <span>{{ $indikator->nama_indikator }}
                                                [{{ $indikator->kode_indikator }}]</span>
                                        </div>
                                    </td>

                                    @for ($minggu = 1; $minggu <= 20; $minggu++)
                                        <td class="px-1 py-1 border-r border-gray-300">
                                            @if (!$viewOnly)
                                                {{-- Mode Edit --}}
                                                <div class="relative group">
                                                    <select
                                                        wire:model="nilaiData.{{ $indikator->id }}.{{ $minggu }}"
                                                        wire:change="updateNilai({{ $indikator->id }}, {{ $minggu }}, $event.target.value)"
                                                        class="w-full px-1 py-1 text-sm text-center border border-gray-200 rounded focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-200
                                            {{ isset($nilaiData[$indikator->id][$minggu])
                                                ? ($nilaiData[$indikator->id][$minggu] == '4'
                                                    ? 'bg-green-100 text-green-800 font-semibold'
                                                    : ($nilaiData[$indikator->id][$minggu] == '3'
                                                        ? 'bg-blue-100 text-blue-800 font-semibold'
                                                        : ($nilaiData[$indikator->id][$minggu] == '2'
                                                            ? 'bg-yellow-100 text-yellow-800 font-semibold'
                                                            : ($nilaiData[$indikator->id][$minggu] == '1'
                                                                ? 'bg-red-100 text-red-800 font-semibold'
                                                                : 'bg-white'))))
                                                : 'bg-white hover:bg-gray-50' }}">
                                                        <option value="">-</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                    </select>

                                                    @if (session()->has('saved_' . $indikator->id . '_' . $minggu))
                                                        <div
                                                            class="absolute -top-6 left-1/2 transform -translate-x-1/2 z-20">
                                                            <span
                                                                class="text-xs text-green-600 bg-white px-1 rounded shadow animate-fade-in-out">✓</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                {{-- Mode View Only --}}
                                                @if (isset($nilaiData[$indikator->id][$minggu]))
                                                    @php $nilai = $nilaiData[$indikator->id][$minggu]; @endphp
                                                    <div
                                                        class="w-full h-full py-1 text-sm text-center rounded
                                            {{ $nilai == '4'
                                                ? 'bg-green-100 text-green-800 font-semibold'
                                                : ($nilai == '3'
                                                    ? 'bg-blue-100 text-blue-800 font-semibold'
                                                    : ($nilai == '2'
                                                        ? 'bg-yellow-100 text-yellow-800 font-semibold'
                                                        : ($nilai == '1'
                                                            ? 'bg-red-100 text-red-800 font-semibold'
                                                            : ''))) }}">
                                                        {{ $nilai }}
                                                    </div>
                                                @else
                                                    <div class="w-full h-full py-1 text-sm text-center text-gray-300">
                                                        -
                                                    </div>
                                                @endif
                                            @endif
                                        </td>
                                    @endfor

                                    @if ($indIndex == 0)
                                        <td rowspan="{{ $aspek->indikator->count() }}"
                                            class="px-4 py-3 text-center text-sm font-bold border-l-2 border-gray-400">
                                            @php
                                                $totalNilaiAspek = 0;
                                                $hasNilai = false;

                                                // Hitung total nilai untuk semua indikator dalam aspek ini
                                                foreach ($aspek->indikator as $ind) {
                                                    for ($m = 1; $m <= 20; $m++) {
                                                        if (
                                                            isset($nilaiData[$ind->id][$m]) &&
                                                            !empty($nilaiData[$ind->id][$m])
                                                        ) {
                                                            $nilai = $nilaiData[$ind->id][$m];
                                                            $totalNilaiAspek += (int) $nilai;
                                                            $hasNilai = true;
                                                        }
                                                    }
                                                }
                                            @endphp
                                            @if ($hasNilai)
                                                <span
                                                    class="inline-flex items-center justify-center min-w-[60px] px-3 py-2 rounded-lg text-lg font-bold
                                            {{ $totalNilaiAspek >= 240
                                                ? 'bg-green-100 text-green-800 border-2 border-green-300'
                                                : ($totalNilaiAspek >= 160
                                                    ? 'bg-blue-100 text-blue-800 border-2 border-blue-300'
                                                    : ($totalNilaiAspek >= 80
                                                        ? 'bg-yellow-100 text-yellow-800 border-2 border-yellow-300'
                                                        : 'bg-red-100 text-red-800 border-2 border-red-300')) }}">
                                                    {{ $totalNilaiAspek }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-lg">-</span>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Footer Keterangan --}}
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-t border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="font-semibold text-gray-700 mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-teal-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Keterangan Nilai:
                        </p>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <div class="flex items-center">
                                <span
                                    class="w-8 h-8 bg-red-100 text-red-800 rounded flex items-center justify-center font-bold mr-2">1</span>
                                <span class="text-gray-600">Belum Berkembang (BB)</span>
                            </div>
                            <div class="flex items-center">
                                <span
                                    class="w-8 h-8 bg-yellow-100 text-yellow-800 rounded flex items-center justify-center font-bold mr-2">2</span>
                                <span class="text-gray-600">Mulai Berkembang (MB)</span>
                            </div>
                            <div class="flex items-center">
                                <span
                                    class="w-8 h-8 bg-blue-100 text-blue-800 rounded flex items-center justify-center font-bold mr-2">3</span>
                                <span class="text-gray-600">Berkembang Sesuai Harapan (BSH)</span>
                            </div>
                            <div class="flex items-center">
                                <span
                                    class="w-8 h-8 bg-green-100 text-green-800 rounded flex items-center justify-center font-bold mr-2">4</span>
                                <span class="text-gray-600">Berkembang Sangat Baik (BSB)</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-end">
                        <div class="text-sm text-gray-500">
                            <p class="flex items-center">
                                <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Nilai otomatis tersimpan saat diubah
                            </p>
                            <p class="flex items-center mt-1">
                                <svg class="w-4 h-4 mr-1 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                @if (!$viewOnly)
                                    Klik "Simpan Semua" untuk memastikan semua data tersimpan
                                @else
                                    Mode tampilan saja (tidak bisa diedit)
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Loading Indicator --}}
    <div wire:loading.flex wire:target="loadNilai"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 items-center justify-center">
        <div class="bg-white p-6 rounded-xl shadow-2xl">
            <div class="flex items-center">
                <svg class="animate-spin h-8 w-8 text-teal-600 mr-3" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span class="text-gray-700 font-medium">Memuat data penilaian...</span>
            </div>
        </div>
    </div>

    {{-- CSS untuk animasi --}}
    <style>
        @keyframes fadeInOut {
            0% {
                opacity: 0;
                transform: translateY(10px);
            }

            20% {
                opacity: 1;
                transform: translateY(0);
            }

            80% {
                opacity: 1;
                transform: translateY(0);
            }

            100% {
                opacity: 0;
                transform: translateY(-10px);
            }
        }

        .animate-fade-in-out {
            animation: fadeInOut 2s ease-in-out;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }

            table {
                font-size: 11px;
            }
        }
    </style>
</div>
