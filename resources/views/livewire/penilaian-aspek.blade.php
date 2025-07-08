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

    {{-- Header Penilaian --}}
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-teal-500 to-blue-600 p-6 text-white">
                <h2 class="text-2xl font-bold text-black flex items-center">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                        </path>
                    </svg>
                    Penilaian Perkelas Per Minggu - Semester {{ $semester }}
                </h2>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {{-- Kolom Kiri --}}
                    <div class="space-y-4">
                        <div class="group">
                            <label class="flex items-center text-gray-700 font-semibold mb-2">
                                <svg class="w-5 h-5 mr-2 text-teal-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                                Kelas
                            </label>
                            <select wire:model.live="selectedKelas"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-teal-500 focus:ring focus:ring-teal-200 transition duration-200">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($kelasList as $kelas)
                                    <option value="{{ $kelas->id_kelas }}">{{ $kelas->namaKelas }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="group">
                            <label class="flex items-center text-gray-700 font-semibold mb-2">
                                <svg class="w-5 h-5 mr-2 text-teal-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Tahun Ajaran
                            </label>
                            <input type="text" value="{{ $tahunAjaran }}"
                                class="w-full px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-lg" readonly>
                        </div>

                        <div class="group">
                            <label class="flex items-center text-gray-700 font-semibold mb-2">
                                <svg class="w-5 h-5 mr-2 text-teal-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Nama Guru
                            </label>
                            <input type="text" value="{{ Auth::user()->name ?? 'Guru Kelas' }}"
                                class="w-full px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-lg" readonly>
                        </div>
                    </div>

                    {{-- Kolom Kanan --}}
                    <div class="space-y-4">
                        <div class="group">
                            <label class="flex items-center text-gray-700 font-semibold mb-2">
                                <svg class="w-5 h-5 mr-2 text-teal-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                                Aspek Penilaian
                            </label>
                            <select wire:model.live="selectedAspek"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-teal-500 focus:ring focus:ring-teal-200 transition duration-200">
                                <option value="">-- Pilih Aspek --</option>
                                @foreach ($aspekList as $aspek)
                                    <option value="{{ $aspek->id_aspek }}">{{ $aspek->nama_aspek }}</option>
                                @endforeach
                            </select>
                        </div>

                        @if ($selectedAspek && $aspekList->where('id_aspek', $selectedAspek)->first())
                            <div class="bg-gradient-to-r from-blue-50 to-teal-50 rounded-lg p-4 border border-blue-200">
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <span class="font-semibold text-gray-700 mr-2">Kode Aspek:</span>
                                        <span
                                            class="bg-white px-3 py-1 rounded-full text-sm font-medium text-teal-600 border border-teal-200">
                                            {{ $aspekList->where('id_aspek', $selectedAspek)->first()->kode_aspek }}
                                        </span>
                                    </div>
                                    @if ($indikatorList->count() > 0)
                                        <div>
                                            <span class="font-semibold text-gray-700">Indikator:</span>
                                            <div class="mt-2 space-y-1">
                                                @foreach ($indikatorList as $ind)
                                                    <div class="flex items-center text-sm text-gray-600">
                                                        <svg class="w-4 h-4 mr-2 text-teal-500" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        {{ $ind->nama_indikator }} <span
                                                            class="ml-1 text-teal-600">[{{ $ind->kode_indikator }}]</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Penilaian --}}
        @if ($selectedKelas && $selectedAspek && $siswaList->count() > 0 && $indikatorList->count() > 0)
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-teal-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            Hasil Penilaian
                        </h3>
                        <button wire:click="simpanNilai" wire:loading.attr="disabled"
                            class="px-4 py-2 bg-gradient-to-r from-teal-500 to-blue-600 text-white rounded-lg hover:from-teal-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-200 flex items-center disabled:opacity-50">
                            <svg wire:loading.remove wire:target="simpanNilai" class="w-5 h-5 mr-2" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                                </path>
                            </svg>
                            <svg wire:loading wire:target="simpanNilai" class="animate-spin h-5 w-5 mr-2"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span wire:loading.remove wire:target="simpanNilai">Simpan Semua</span>
                            <span wire:loading wire:target="simpanNilai">Menyimpan...</span>
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-100 to-gray-200">
                                <th rowspan="2"
                                    class="sticky left-0 z-10 bg-gray-100 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-r-2 border-gray-300">
                                    No
                                </th>
                                <th rowspan="2"
                                    class="sticky left-12 z-10 bg-gray-100 px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-r-2 border-gray-300">
                                    Nama<br>Siswa
                                </th>
                                <th rowspan="2"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-r-2 border-gray-300 min-w-[200px]">
                                    Indikator
                                </th>
                                <th colspan="20"
                                    class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r-2 border-gray-300">
                                    Minggu Ke
                                </th>
                                <th rowspan="2"
                                    class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Rata-<br>rata
                                </th>
                            </tr>
                            <tr class="bg-gradient-to-r from-gray-100 to-gray-200">
                                @for ($i = 1; $i <= 20; $i++)
                                    <th
                                        class="px-2 py-2 text-center text-xs font-medium text-gray-700 border-r border-gray-300 min-w-[45px]">
                                        {{ $i }}
                                    </th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($siswaList as $index => $siswa)
                                @foreach ($indikatorList as $indIndex => $indikator)
                                    <tr
                                        class="hover:bg-gray-50 {{ $indIndex == 0 ? 'border-t-2 border-gray-400' : '' }}">
                                        @if ($indIndex == 0)
                                            <td rowspan="{{ $indikatorList->count() }}"
                                                class="sticky left-0 z-10 bg-white px-4 py-3 text-center text-sm font-medium text-gray-900 border-r-2 border-gray-300">
                                                {{ $index + 1 }}
                                            </td>
                                            <td rowspan="{{ $indikatorList->count() }}"
                                                class="sticky left-12 z-10 bg-white px-4 py-3 text-sm font-semibold text-gray-900 border-r-2 border-gray-300">
                                                {{ $siswa->namaSiswa }}
                                            </td>
                                        @endif

                                        <td class="px-4 py-3 text-sm text-gray-700 border-r-2 border-gray-300">
                                            {{ $indikator->nama_indikator }}
                                        </td>

                                        @for ($minggu = 1; $minggu <= 20; $minggu++)
                                            <td class="px-1 py-1 border-r border-gray-300">
                                                <div class="relative group">
                                                    <select
                                                        wire:model="nilaiData.{{ $siswa->id_akunsiswa }}.{{ $indikator->id }}.{{ $minggu }}"
                                                        wire:change="updateNilai({{ $siswa->id_akunsiswa }}, {{ $indikator->id }}, {{ $minggu }}, $event.target.value)"
                                                        class="w-full px-1 py-1 text-sm text-center border border-gray-200 rounded focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-200
                                            {{ isset($nilaiData[$siswa->id_akunsiswa][$indikator->id][$minggu])
                                                ? ($nilaiData[$siswa->id_akunsiswa][$indikator->id][$minggu] == '4'
                                                    ? 'bg-green-100 text-green-800 font-semibold'
                                                    : ($nilaiData[$siswa->id_akunsiswa][$indikator->id][$minggu] == '3'
                                                        ? 'bg-blue-100 text-blue-800 font-semibold'
                                                        : ($nilaiData[$siswa->id_akunsiswa][$indikator->id][$minggu] == '2'
                                                            ? 'bg-yellow-100 text-yellow-800 font-semibold'
                                                            : ($nilaiData[$siswa->id_akunsiswa][$indikator->id][$minggu] == '1'
                                                                ? 'bg-red-100 text-red-800 font-semibold'
                                                                : 'bg-white'))))
                                                : 'bg-white hover:bg-gray-50' }}">
                                                        <option value="">-</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                    </select>

                                                    @if (session()->has('saved_' . $siswa->id_akunsiswa . '_' . $indikator->id . '_' . $minggu))
                                                        <div
                                                            class="absolute -top-6 left-1/2 transform -translate-x-1/2 z-20">
                                                            <span
                                                                class="text-xs text-green-600 bg-white px-1 rounded shadow animate-fade-in-out">✓</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                        @endfor

                                        @if ($indIndex == 0)
                                            <td rowspan="{{ $indikatorList->count() }}"
                                                class="px-4 py-3 text-center text-sm font-bold">
                                                @php
                                                    $totalNilai = 0;
                                                    $countNilai = 0;
                                                    foreach ($indikatorList as $ind) {
                                                        for ($m = 1; $m <= 20; $m++) {
                                                            if (
                                                                isset($nilaiData[$siswa->id_akunsiswa][$ind->id][$m]) &&
                                                                !empty($nilaiData[$siswa->id_akunsiswa][$ind->id][$m])
                                                            ) {
                                                                $nilai = $nilaiData[$siswa->id_akunsiswa][$ind->id][$m];
                                                                $totalNilai += (int) $nilai;
                                                                $countNilai++;
                                                            }
                                                        }
                                                    }
                                                    $rataRata = $countNilai > 0 ? $totalNilai / $countNilai : 0;
                                                @endphp
                                                @if ($rataRata > 0)
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                            {{ $rataRata >= 3.5
                                                ? 'bg-green-100 text-green-800'
                                                : ($rataRata >= 2.5
                                                    ? 'bg-blue-100 text-blue-800'
                                                    : ($rataRata >= 1.5
                                                        ? 'bg-yellow-100 text-yellow-800'
                                                        : 'bg-red-100 text-red-800')) }}">
                                                        {{ number_format($rataRata, 2) }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">-</span>
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

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($selectedKelas && $selectedAspek)
            <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                <p class="text-gray-500 text-lg">
                    @if ($siswaList->count() == 0)
                        Tidak ada siswa di kelas ini.
                    @elseif($indikatorList->count() == 0)
                        Tidak ada indikator untuk aspek ini.
                    @else
                        Silakan pilih kelas dan aspek penilaian.
                    @endif
                </p>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-xl p-12">
                <div class="max-w-md mx-auto text-center">
                    <svg class="w-32 h-32 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                        </path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Mulai Penilaian</h3>
                    <p class="text-gray-500">Silakan pilih kelas dan aspek penilaian untuk memulai input nilai siswa
                    </p>
                </div>
            </div>
        @endif
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

        /* Sticky column styles */
        .sticky {
            position: sticky;
            background-color: white;
        }

        tbody tr:hover .sticky {
            background-color: #f9fafb;
        }
    </style>
</div
