<div class="p-6 bg-gray-100 min-h-screen space-y-6">

    {{-- Card Admin Login --}}
    <a href="{{ route('profil.admin') }}" class="block transition-transform duration-300 transform hover:-translate-y-1">
        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 shadow-xl rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold">Informasi Admin</h3>
                    @if ($adminLogin)
                        <p class="mt-1 font-medium">{{ $adminLogin->username }}</p>
                        <p class="text-sm opacity-90">Email: {{ $adminLogin->email }}</p>
                        <p class="text-sm opacity-90">Telepon: {{ $adminLogin->notlp }}</p>
                    @else
                        <p class="text-sm opacity-90">Belum login</p>
                    @endif
                </div>
                <div class="text-4xl opacity-30">
                    <i class="fas fa-user-shield"></i>
                </div>
            </div>
        </div>
    </a>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Jumlah Siswa -->
        <a href="{{ route('admin.data-account') }}"
            class="block transition-transform duration-300 transform hover:-translate-y-1">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 shadow-xl rounded-xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold">Jumlah Siswa</h3>
                        <p class="text-4xl font-bold mt-2">{{ $jumlahSiswa }}</p>
                    </div>
                    <div class="text-4xl opacity-30">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                </div>
            </div>
        </a>

        <!-- Jumlah Guru -->
        <a href="{{ route('admin.data-account') }}"
            class="block transition-transform duration-300 transform hover:-translate-y-1">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 shadow-xl rounded-xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold">Jumlah Guru</h3>
                        <p class="text-4xl font-bold mt-2">{{ $jumlahGuru }}</p>
                    </div>
                    <div class="text-4xl opacity-30">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                </div>
            </div>
        </a>

        <!-- Jumlah Kelas -->
        <a href="{{ route('admin.master-data') }}"
            class="block transition-transform duration-300 transform hover:-translate-y-1">
            <div class="bg-gradient-to-r from-green-500 to-green-600 shadow-xl rounded-xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold">Jumlah Kelas</h3>
                        <p class="text-4xl font-bold mt-2">{{ $jumlahKelas }}</p>
                    </div>
                    <div class="text-4xl opacity-30">
                        <i class="fas fa-school"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
