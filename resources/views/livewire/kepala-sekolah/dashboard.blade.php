<div class="p-6 bg-gray-100 min-h-screen space-y-6">

    {{-- Card: Detail Kepala Sekolah --}}
    <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 shadow-xl rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold">Informasi Kepala Sekolah</h3>
                @if ($kepsekLogin)
                    <p class="mt-1 font-medium">{{ $kepsekLogin->username }}</p>
                    <p class="text-sm opacity-90">Email: {{ $kepsekLogin->email }}</p>
                    <p class="text-sm opacity-90">Telepon: {{ $kepsekLogin->notlp }}</p>
                @else
                    <p class="text-sm opacity-90">Belum login</p>
                @endif
            </div>
            <div class="text-4xl opacity-30">
                <i class="fas fa-user-tie"></i>
            </div>
        </div>
    </div>

    <div class="w-full grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">

        {{-- Total Siswa --}}
        <div
            class="group relative bg-gradient-to-br from-red-50 to-red-100 rounded-xl shadow-md hover:shadow-lg transition p-4 border border-red-200 overflow-hidden">
            <div class="absolute top-0 right-0 -mt-2 -mr-2 w-12 h-12 bg-red-500/10 rounded-full"></div>
            <div class="flex items-center justify-between mb-3">
                <div class="bg-red-500 rounded-lg p-2 shadow-md group-hover:scale-110 transition">
                    <i class="fas fa-user-graduate text-white"></i>
                </div>
            </div>
            <div class="space-y-1">
                <h3 class="text-red-800 font-medium text-sm">Total Siswa</h3>
                <p class="text-2xl font-bold text-red-900">
                    {{ collect($totalSiswaPerKelas)->sum('jumlahSiswa') }}
                </p>
            </div>
        </div>

        {{-- Total Guru --}}
        <div
            class="group relative bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl shadow-md hover:shadow-lg transition p-4 border border-emerald-200">
            <div class="absolute top-0 right-0 -mt-2 -mr-2 w-12 h-12 bg-emerald-500/10 rounded-full"></div>
            <div class="flex items-center justify-between mb-3">
                <div class="bg-emerald-500 rounded-lg p-2 shadow-md group-hover:scale-110 transition">
                    <i class="fas fa-chalkboard-teacher text-white"></i>
                </div>
            </div>
            <div class="space-y-1">
                <h3 class="text-emerald-800 font-medium text-sm">Total Guru</h3>
                <p class="text-2xl font-bold text-emerald-900">{{ $totalGuru }}</p>
            </div>
        </div>

        {{-- Card per Kelas --}}
        @php
            $warnaKelas = [
                [
                    'from' => 'blue-50',
                    'to' => 'blue-100',
                    'border' => 'blue-200',
                    'icon' => 'blue-500',
                    'text' => 'blue-800',
                    'number' => 'blue-900',
                ],
                [
                    'from' => 'purple-50',
                    'to' => 'purple-100',
                    'border' => 'purple-200',
                    'icon' => 'purple-500',
                    'text' => 'purple-800',
                    'number' => 'purple-900',
                ],
                [
                    'from' => 'amber-50',
                    'to' => 'amber-100',
                    'border' => 'amber-200',
                    'icon' => 'amber-500',
                    'text' => 'amber-800',
                    'number' => 'amber-900',
                ],
                [
                    'from' => 'pink-50',
                    'to' => 'pink-100',
                    'border' => 'pink-200',
                    'icon' => 'pink-500',
                    'text' => 'pink-800',
                    'number' => 'pink-900',
                ],
                [
                    'from' => 'teal-50',
                    'to' => 'teal-100',
                    'border' => 'teal-200',
                    'icon' => 'teal-500',
                    'text' => 'teal-800',
                    'number' => 'teal-900',
                ],
                [
                    'from' => 'cyan-50',
                    'to' => 'cyan-100',
                    'border' => 'cyan-200',
                    'icon' => 'cyan-500',
                    'text' => 'cyan-800',
                    'number' => 'cyan-900',
                ],
            ];
        @endphp

        @foreach ($totalSiswaPerKelas as $i => $kelas)
            @php $c = $warnaKelas[$i % count($warnaKelas)]; @endphp
            <div
                class="group relative bg-gradient-to-br from-{{ $c['from'] }} to-{{ $c['to'] }} rounded-xl shadow-md hover:shadow-lg transition p-4 border border-{{ $c['border'] }} overflow-hidden">
                <div class="absolute top-0 right-0 -mt-2 -mr-2 w-12 h-12 bg-{{ $c['icon'] }}/10 rounded-full"></div>
                <div class="flex items-center justify-between mb-3">
                    <div class="bg-{{ $c['icon'] }} rounded-lg p-2 shadow-md group-hover:scale-110 transition">
                        <i class="fas fa-school text-white"></i>
                    </div>
                </div>
                <div class="space-y-1">
                    <h3 class="text-{{ $c['text'] }} font-medium text-sm">{{ $kelas['namaKelas'] }}</h3>
                    <p class="text-2xl font-bold text-{{ $c['number'] }}">{{ $kelas['jumlahSiswa'] }}</p>
                </div>
            </div>
        @endforeach

        {{-- Total Aspek --}}
        <div
            class="group relative bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl shadow-md hover:shadow-lg transition p-4 border border-indigo-200 overflow-hidden">
            <div class="absolute top-0 right-0 -mt-2 -mr-2 w-12 h-12 bg-indigo-500/10 rounded-full"></div>
            <div class="flex items-center justify-between mb-3">
                <div class="bg-indigo-500 rounded-lg p-2 shadow-md group-hover:scale-110 transition">
                    <i class="fas fa-list-alt text-white"></i>
                </div>
            </div>
            <div class="space-y-1">
                <h3 class="text-indigo-800 font-medium text-sm">Total Aspek</h3>
                <p class="text-2xl font-bold text-indigo-900">{{ $totalAspekPenilaian }}</p>
            </div>
        </div>

    </div>
</div>
