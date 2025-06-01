<div class="w-full grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
    {{-- Card: Total Siswa --}}
    <div
        class="group relative bg-gradient-to-br from-red-50 to-red-100 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 p-4 border border-red-200 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute top-0 right-0 -mt-2 -mr-2 w-12 h-12 bg-red-500/10 rounded-full"></div>

        <!-- Icon -->
        <div class="flex items-center justify-between mb-3">
            <div class="bg-red-500 rounded-lg p-2 shadow-md group-hover:scale-110 transition-transform duration-300">
                <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                </svg>
            </div>
        </div>

        <!-- Content -->
        <div class="space-y-1">
            <h3 class="text-red-800 font-medium text-sm">Total Siswa</h3>
            <p class="text-2xl font-bold text-red-900">{{ collect($totalSiswaPerKelas)->sum('jumlahSiswa') }}</p>
        </div>
    </div>

    {{-- Card: Total Guru --}}
    <div
        class="group relative bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 p-4 border border-emerald-200 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute top-0 right-0 -mt-2 -mr-2 w-12 h-12 bg-emerald-500/10 rounded-full"></div>

        <!-- Icon -->
        <div class="flex items-center justify-between mb-3">
            <div
                class="bg-emerald-500 rounded-lg p-2 shadow-md group-hover:scale-110 transition-transform duration-300">
                <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z" />
                </svg>
            </div>
        </div>

        <!-- Content -->
        <div class="space-y-1">
            <h3 class="text-emerald-800 font-medium text-sm">Total Guru</h3>
            <p class="text-2xl font-bold text-emerald-900">{{ $totalGuru }}</p>
        </div>
    </div>

    {{-- Card Kelas (Loop) --}}
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
        @php $colors = $warnaKelas[$i % count($warnaKelas)]; @endphp
        <div
            class="group relative bg-gradient-to-br from-{{ $colors['from'] }} to-{{ $colors['to'] }} rounded-xl shadow-md hover:shadow-lg transition-all duration-300 p-4 border border-{{ $colors['border'] }} overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute top-0 right-0 -mt-2 -mr-2 w-12 h-12 bg-{{ $colors['icon'] }}/10 rounded-full"></div>

            <!-- Icon -->
            <div class="flex items-center justify-between mb-3">
                <div
                    class="bg-{{ $colors['icon'] }} rounded-lg p-2 shadow-md group-hover:scale-110 transition-transform duration-300">
                    <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z" />
                    </svg>
                </div>
            </div>

            <!-- Content -->
            <div class="space-y-1">
                <h3 class="text-{{ $colors['text'] }} font-medium text-sm">{{ $kelas['namaKelas'] }}</h3>
                <p class="text-2xl font-bold text-{{ $colors['number'] }}">{{ $kelas['jumlahSiswa'] }}</p>
            </div>
        </div>
    @endforeach

    {{-- Card: Total Aspek --}}
    <div
        class="group relative bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 p-4 border border-indigo-200 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute top-0 right-0 -mt-2 -mr-2 w-12 h-12 bg-indigo-500/10 rounded-full"></div>

        <!-- Icon -->
        <div class="flex items-center justify-between mb-3">
            <div class="bg-indigo-500 rounded-lg p-2 shadow-md group-hover:scale-110 transition-transform duration-300">
                <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Content -->
        <div class="space-y-1">
            <h3 class="text-indigo-800 font-medium text-sm">Total Aspek</h3>
            <p class="text-2xl font-bold text-indigo-900">{{ $totalAspekPenilaian }}</p>
        </div>
    </div>
</div>
