<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
            <div class="flex items-center mb-6">
                <button wire:click="backToIndikator"
                    class="mr-4 p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-900">Daftar Siswa</h1>
                    <p class="text-gray-600 mt-1">
                        {{ $indikator->kode_indikator }} — {{ $indikator->nama_indikator }}
                    </p>
                </div>
                <div class="text-sm text-gray-500">
                    Total: {{ $siswaList->total() }} siswa
                </div>
            </div>

            <!-- Search & Per Page -->
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <input wire:model.live="search" type="text"
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                            placeholder="Cari nama siswa atau kelas...">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <select wire:model.live="perPage"
                    class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    <option value="10">10 per halaman</option>
                    <option value="25">25 per halaman</option>
                    <option value="50">50 per halaman</option>
                </select>
            </div>
        </div>

        <!-- Students Table -->
        <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Siswa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($siswaList as $i => $siswa)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $siswaList->firstItem() + $i }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center">
                                            <span class="text-purple-600 font-medium text-xs">
                                                {{ strtoupper(substr($siswa->namaSiswa, 0, 2)) }}
                                            </span>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $siswa->namaSiswa }}</div>
                                            <div class="text-sm text-gray-500">ID: {{ $siswa->id_akunsiswa }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $siswa->kelas->namaKelas }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ in_array($siswa->id_akunsiswa, $checkedIds) ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        <span
                                            class="w-1.5 h-1.5 {{ in_array($siswa->id_akunsiswa, $checkedIds) ? 'bg-green-400' : 'bg-red-400' }} rounded-full mr-1.5"></span>
                                        {{ in_array($siswa->id_akunsiswa, $checkedIds) ? 'Sudah' : 'Belum' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @php
                                        // Ambil nilai existing untuk hari ini & indikator ini
                                        $existing = \App\Models\NilaiSiswa::whereHas(
                                            'penilaian',
                                            fn($q) => $q
                                                ->where('id_akunsiswa', $siswa->id_akunsiswa)
                                                ->where('tgl_penilaian', today()->toDateString()),
                                        )
                                            ->where('indikator_aspek_id', $indikator->id)
                                            ->value('nilai');
                                    @endphp

                                    <select wire:change="setNilai({{ $siswa->id_akunsiswa }}, $event.target.value)"
                                        class="border border-gray-300 rounded-lg px-2 py-1 text-sm">
                                        <option value="">— Pilih Nilai —</option>
                                        @foreach ([
        'BSB' => 'Berkembang Sangat Baik',
        'BSH' => 'Berkembang Sesuai Harapan',
        'MB' => 'Mulai Berkembang',
        'BB' => 'Belum Berkembang',
    ] as $key => $label)
                                            <option value="{{ $key }}"
                                                @if ($existing === $key) selected @endif>
                                                {{ $key }} — {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex justify-center space-x-4">
                                        @php
                                            $existing = \App\Models\NilaiSiswa::whereHas(
                                                'penilaian',
                                                fn($q) => $q
                                                    ->where('id_akunsiswa', $siswa->id_akunsiswa)
                                                    ->where('tgl_penilaian', today()->toDateString()),
                                            )
                                                ->where('indikator_aspek_id', $indikator->id)
                                                ->value('nilai');
                                        @endphp

                                        @foreach (['BSB', 'BSH', 'MB', 'BB'] as $opt)
                                            <label class="inline-flex items-center space-x-1">
                                                <input type="radio" name="nilai_{{ $siswa->id_akunsiswa }}"
                                                    value="{{ $opt }}"
                                                    wire:click="setNilai({{ $siswa->id_akunsiswa }}, '{{ $opt }}')"
                                                    @if ($existing === $opt) checked @endif
                                                    class="form-radio h-4 w-4 text-purple-600" />
                                                <span class="text-xs font-medium">{{ $opt }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </td>


                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if ($siswaList->hasPages())
            <div class="bg-white rounded-lg shadow-sm border p-4 mt-6">
                {{ $siswaList->links() }}
            </div>
        @endif
    </div>
</div>
