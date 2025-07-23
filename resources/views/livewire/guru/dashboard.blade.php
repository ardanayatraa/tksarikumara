<div class="p-6 bg-gray-100 min-h-screen">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Card Guru Login -->
        <a href="{{ route('profil.guru') }}"
            class="block transition-transform duration-300 transform hover:-translate-y-1">
            <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 shadow-xl rounded-xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold">Informasi Guru</h3>
                        @if ($guruLogin)
                            <p class="mt-1 font-medium">{{ $guruLogin->namaGuru }}</p>
                            <p class="text-sm opacity-90">NIP: {{ $guruLogin->nip }}</p>
                            <p class="text-sm opacity-90">Email: {{ $guruLogin->email }}</p>
                            <p class="text-sm opacity-90">Telp: {{ $guruLogin->notlp }}</p>
                        @else
                            <p class="text-sm opacity-90">Belum login</p>
                        @endif
                    </div>
                    <div class="text-4xl opacity-30">
                        <i class="fas fa-user-tie"></i>
                    </div>
                </div>
            </div>
        </a>

        <!-- Card Detail Kelas -->
        <a href="{{ route('guru.penilaian') }}"
            class="block transition-transform duration-300 transform hover:-translate-y-1">
            <div class="bg-gradient-to-r from-green-500 to-green-600 shadow-xl rounded-xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold">Kelas Anda</h3>
                        @if ($kelasGuru)
                            <p class="mt-1 font-medium">{{ $kelasGuru->namaKelas }}</p>
                            <p class="text-sm opacity-90">Tahun Ajaran: {{ $kelasGuru->tahunAjaran }}</p>
                            <p class="text-sm opacity-90">Total Siswa: {{ $jumlahSiswaDiKelas }}</p>
                        @else
                            <p class="text-sm opacity-90">Belum ada kelas</p>
                        @endif
                    </div>
                    <div class="text-4xl opacity-30">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                </div>
            </div>
        </a>

        <!-- Card Jumlah Murid -->
        <a href="{{ route('guru.aspek-penilaian') }}"
            class="block transition-transform duration-300 transform hover:-translate-y-1">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 shadow-xl rounded-xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold">Aspek Penilaian</h3>
                        <p class="text-5xl font-bold mt-2">
                            {{ $jumlahSiswaDiKelas }}
                        </p>
                        <p class="text-sm opacity-90 mt-2">Siswa untuk dinilai</p>
                    </div>
                    <div class="text-4xl opacity-30">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                </div>
            </div>
        </a>

    </div>
</div>
