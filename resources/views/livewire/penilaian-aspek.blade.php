<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-teal-50">
    {{-- Font Awesome CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
                        <i class="fas fa-check-circle text-xl mr-2"></i>
                    @else
                        <i class="fas fa-exclamation-circle text-xl mr-2"></i>
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
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <i class="fas fa-clipboard-list text-3xl mr-3"></i>
                    Penilaian Perkelas Per Minggu - Semester {{ $semester }}
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {{-- Kolom Kiri --}}
                    <div class="space-y-4">
                        <div class="group">
                            <label class="flex items-center text-gray-700 font-semibold mb-2">
                                <i class="fas fa-school text-teal-500 mr-2"></i>
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
                                <i class="fas fa-calendar-alt text-teal-500 mr-2"></i>
                                Tahun Ajaran
                            </label>
                            <input type="text" value="{{ $tahunAjaran }}"
                                class="w-full px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-lg" readonly>
                        </div>
                        <div class="group">
                            <label class="flex items-center text-gray-700 font-semibold mb-2">
                                <i class="fas fa-user-tie text-teal-500 mr-2"></i>
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
                                <i class="fas fa-tasks text-teal-500 mr-2"></i>
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
                                                    <div
                                                        class="flex items-center justify-between text-sm text-gray-600 bg-white rounded p-2">
                                                        <div class="flex items-center">
                                                            <i class="fas fa-check-circle text-teal-500 mr-2"></i>
                                                            <span>{{ $ind->nama_indikator }} <span
                                                                    class="ml-1 text-teal-600">[{{ $ind->kode_indikator }}]</span></span>
                                                        </div>
                                                        <span
                                                            class="bg-teal-100 text-teal-800 px-2 py-1 rounded-full text-xs font-semibold">
                                                            <i
                                                                class="fas fa-weight-hanging mr-1"></i>{{ $ind->bobot }}
                                                        </span>
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
                            <i class="fas fa-chart-line text-teal-500 mr-2"></i>
                            Hasil Penilaian (Sistem Checkbox)
                        </h3>
                        {{-- <button wire:click="simpanNilai" wire:loading.attr="disabled"
                            class="px-4 py-2 bg-gradient-to-r from-teal-500 to-blue-600 text-white rounded-lg hover:from-teal-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-teal-500 transition duration-200 flex items-center disabled:opacity-50">
                            <i wire:loading.remove wire:target="simpanNilai" class="fas fa-save mr-2"></i>
                            <i wire:loading wire:target="simpanNilai" class="fas fa-spinner fa-spin mr-2"></i>
                            <span wire:loading.remove wire:target="simpanNilai">Simpan Semua</span>
                            <span wire:loading wire:target="simpanNilai">Menyimpan...</span>
                        </button> --}}
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
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-r-2 border-gray-300 min-w-[250px]">
                                    Indikator (Bobot)
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
                                                <i class="fas fa-user-graduate text-teal-500 mr-2"></i>
                                                {{ $siswa->namaSiswa }}
                                            </td>
                                        @endif
                                        <td class="px-4 py-3 text-sm text-gray-700 border-r-2 border-gray-300">
                                            <div class="flex items-center justify-between">
                                                <span>{{ $indikator->nama_indikator }}</span>
                                                <span
                                                    class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold ml-2">
                                                    <i class="fas fa-weight-hanging mr-1"></i>{{ $indikator->bobot }}
                                                </span>
                                            </div>
                                        </td>
                                        @for ($minggu = 1; $minggu <= 20; $minggu++)
                                            <td class="px-1 py-1 border-r border-gray-300">
                                                <div class="relative group flex justify-center">
                                                    <input type="checkbox"
                                                        {{ isset($nilaiData[$siswa->id_akunsiswa][$indikator->id][$minggu]) && $nilaiData[$siswa->id_akunsiswa][$indikator->id][$minggu] ? 'checked' : '' }}
                                                        wire:click="toggleNilai({{ $siswa->id_akunsiswa }}, {{ $indikator->id }}, {{ $minggu }})"
                                                        class="w-5 h-5 text-teal-600 bg-gray-100 border-gray-300 rounded focus:ring-teal-500 focus:ring-2 transition duration-200 cursor-pointer
                {{ isset($nilaiData[$siswa->id_akunsiswa][$indikator->id][$minggu]) && $nilaiData[$siswa->id_akunsiswa][$indikator->id][$minggu] ? 'bg-teal-100 border-teal-500' : 'hover:bg-gray-50' }}">

                                                    @if (session()->has('saved_' . $siswa->id_akunsiswa . '_' . $indikator->id . '_' . $minggu))
                                                        <div
                                                            class="absolute -top-6 left-1/2 transform -translate-x-1/2 z-20">
                                                            <span
                                                                class="text-xs text-green-600 bg-white px-1 rounded shadow animate-fade-in-out">
                                                                <i class="fas fa-check"></i>
                                                            </span>
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
                                                                $nilaiData[$siswa->id_akunsiswa][$ind->id][$m] === true
                                                            ) {
                                                                $totalNilai += $ind->bobot;
                                                                $countNilai++;
                                                            } elseif (
                                                                isset($nilaiData[$siswa->id_akunsiswa][$ind->id][$m])
                                                            ) {
                                                                // Hitung juga yang tidak dicentang untuk pembagi
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
                                                        <i class="fas fa-calculator mr-1"></i>
                                                        {{ number_format($rataRata, 2) }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">
                                                        <i class="fas fa-minus"></i>
                                                    </span>
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
                        <div class="flex items-center">
                            <div class="text-sm text-gray-600">
                                <p class="flex items-center mb-2">
                                    <i class="fas fa-check-square text-green-500 mr-2"></i>
                                    Centang checkbox jika indikator tercapai
                                </p>
                                <p class="flex items-center">
                                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                                    Nilai otomatis tersimpan berdasarkan bobot indikator
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center justify-end">
                            <div class="text-sm text-gray-500">
                                <p><i class="fas fa-users mr-1"></i>Total Siswa: <span
                                        class="font-semibold">{{ $siswaList->count() }}</span></p>
                                <p><i class="fas fa-list-ul mr-1"></i>Total Indikator: <span
                                        class="font-semibold">{{ $indikatorList->count() }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($selectedKelas && $selectedAspek)
            <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
                <i class="fas fa-file-alt text-gray-300 text-8xl mb-4"></i>
                <p class="text-gray-500 text-lg">
                    @if ($siswaList->count() == 0)
                        <i class="fas fa-user-times mr-2"></i>Tidak ada siswa di kelas ini.
                    @elseif($indikatorList->count() == 0)
                        <i class="fas fa-list-alt mr-2"></i>Tidak ada indikator untuk aspek ini.
                    @else
                        Silakan pilih kelas dan aspek penilaian.
                    @endif
                </p>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-xl p-12">
                <div class="max-w-md mx-auto text-center">
                    <i class="fas fa-clipboard-check text-gray-300 text-8xl mb-6"></i>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">
                        <i class="fas fa-play-circle mr-2"></i>Mulai Penilaian
                    </h3>
                    <p class="text-gray-500">Silakan pilih kelas dan aspek penilaian untuk memulai input nilai siswa
                        dengan sistem checkbox</p>
                </div>
            </div>
        @endif
    </div>

    {{-- Loading Indicator --}}
    <div wire:loading.flex wire:target="loadNilai"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 items-center justify-center">
        <div class="bg-white p-6 rounded-xl shadow-2xl">
            <div class="flex items-center">
                <i class="fas fa-spinner fa-spin text-teal-600 text-2xl mr-3"></i>
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

        /* Checkbox hover effects */
        input[type="checkbox"]:hover {
            transform: scale(1.1);
        }

        input[type="checkbox"]:checked {
            background-color: #0d9488;
            border-color: #0d9488;
        }

        /* Font Awesome icon hover effects */
        .fa-check-square:hover,
        .fa-info-circle:hover {
            transform: scale(1.1);
            transition: transform 0.2s ease;
        }
    </style>
</div>
