<div class="w-full mx-auto">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-emerald-100">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-emerald-50 to-emerald-100 px-6 py-8 border-b border-emerald-200">
            <div class="flex items-center space-x-4">

                <div>
                    <h2 class="text-3xl font-bold text-emerald-800">Profil Siswa</h2>
                    <p class="text-emerald-600 mt-1">Kelola informasi profil dan data pribadi Anda</p>
                </div>
            </div>
        </div>

        <div class="px-6 py-8">
            <!-- Notifikasi sukses -->
            @if (session()->has('message'))
                <div
                    class="mb-6 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg flex items-center space-x-3">
                    <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ session('message') }}</span>
                </div>
            @endif

            <!-- Form Profil -->
            <form wire:submit.prevent="updateProfil" class=" flex flex-col gap-8">

                <!-- Foto Profil Section -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="h-5 w-5 text-emerald-500 mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Foto Profil
                    </h3>

                    <div class="flex items-center space-x-6">
                        <div class="flex-shrink-0">
                            @if ($foto)
                                <img src="{{ $foto->temporaryUrl() }}"
                                    class="h-24 w-24 rounded-full object-cover border-4 border-emerald-200 shadow-lg" />
                                <p class="text-sm text-emerald-600 mt-2 text-center">Preview Baru</p>
                            @elseif($fotoPreview)
                                <img src="{{ asset('storage/' . $fotoPreview) }}"
                                    class="h-24 w-24 rounded-full object-cover border-4 border-gray-200 shadow-lg" />
                                <p class="text-sm text-gray-600 mt-2 text-center">Foto Saat Ini</p>
                            @else
                                <div
                                    class="h-24 w-24 rounded-full bg-gray-200 flex items-center justify-center border-4 border-gray-300">
                                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-500 mt-2 text-center">Tidak ada foto</p>
                            @endif
                        </div>

                        <div class="flex-1">
                            <x-label for="foto" value="Upload Foto Baru (Opsional)"
                                class="text-sm font-medium text-gray-700" />
                            <x-input id="foto" type="file" wire:model="foto" accept="image/*"
                                class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-gray-300 rounded-lg" />
                            @error('foto')
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                            <p class="text-gray-500 text-xs mt-2">Format: JPG, PNG. Maksimal 2MB.</p>
                        </div>
                    </div>
                </div>

                <!-- Informasi Akademik -->
                <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="h-5 w-5 text-blue-500 mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        Informasi Akademik
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Kelas --}}
                        <div>
                            <x-label for="id_kelas" value="Kelas" class="text-sm font-medium text-gray-700" />
                            <select id="id_kelas" wire:model.defer="id_kelas"
                                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($kelasList as $k)
                                    <option value="{{ $k->id_kelas }}">{{ $k->namaKelas }}</option>
                                @endforeach
                            </select>
                            @error('id_kelas')
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- NISN --}}
                        <div>
                            <x-label for="nisn" value="NISN" class="text-sm font-medium text-gray-700" />
                            <x-input id="nisn" wire:model.defer="nisn"
                                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                placeholder="Masukkan NISN" />
                            @error('nisn')
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Informasi Pribadi -->
                <div class="bg-purple-50 rounded-xl p-6 border border-purple-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="h-5 w-5 text-purple-500 mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Informasi Pribadi
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nama Siswa --}}
                        <div class="md:col-span-2">
                            <x-label for="namaSiswa" value="Nama Lengkap Siswa"
                                class="text-sm font-medium text-gray-700" />
                            <x-input id="namaSiswa" wire:model.defer="namaSiswa"
                                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                placeholder="Masukkan nama lengkap siswa" />
                            @error('namaSiswa')
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div>
                            <x-label for="tgl_lahir" value="Tanggal Lahir"
                                class="text-sm font-medium text-gray-700" />
                            <x-input id="tgl_lahir" type="date" wire:model.defer="tgl_lahir"
                                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition-colors" />
                            @error('tgl_lahir')
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div>
                            <x-label for="jenis_kelamin" value="Jenis Kelamin"
                                class="text-sm font-medium text-gray-700" />
                            <select id="jenis_kelamin" wire:model.defer="jenis_kelamin"
                                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Alamat --}}
                        <div class="md:col-span-2">
                            <x-label for="alamat" value="Alamat Lengkap"
                                class="text-sm font-medium text-gray-700" />
                            <textarea id="alamat" wire:model.defer="alamat" rows="3"
                                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition-colors resize-none"
                                placeholder="Masukkan alamat lengkap"></textarea>
                            @error('alamat')
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Informasi Keluarga -->
                <div class="bg-orange-50 rounded-xl p-6 border border-orange-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="h-5 w-5 text-orange-500 mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        Informasi Keluarga
                    </h3>

                    <div>
                        {{-- Nama Orang Tua --}}
                        <div>
                            <x-label for="namaOrangTua" value="Nama Orang Tua / Wali"
                                class="text-sm font-medium text-gray-700" />
                            <x-input id="namaOrangTua" wire:model.defer="namaOrangTua"
                                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                placeholder="Masukkan nama orang tua atau wali" />
                            @error('namaOrangTua')
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Informasi Akun -->
                <div class="bg-indigo-50 rounded-xl p-6 border border-indigo-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                        Informasi Akun
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Email --}}
                        <div>
                            <x-label for="email" value="Email" class="text-sm font-medium text-gray-700" />
                            <x-input id="email" type="email" wire:model.defer="email"
                                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                placeholder="contoh@email.com" />
                            @error('email')
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Username --}}
                        <div>
                            <x-label for="username" value="Username" class="text-sm font-medium text-gray-700" />
                            <x-input id="username" wire:model.defer="username"
                                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                placeholder="Masukkan username" />
                            @error('username')
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="md:col-span-2">
                            <x-label for="password" value="Password Baru (Opsional)"
                                class="text-sm font-medium text-gray-700" />
                            <x-input id="password" type="password" wire:model.defer="password"
                                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                placeholder="Masukkan password baru" />
                            @error('password')
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                            <div class="mt-2 flex items-center space-x-2">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-gray-500 text-sm">Kosongkan jika tidak ingin mengganti password.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="flex justify-end pt-6 border-t border-gray-200">
                    <div class="flex space-x-3">
                        <button type="button"
                            class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-colors font-medium">
                            Batal
                        </button>
                        <x-button type="submit"
                            class="px-8 py-3 bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-500 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 flex items-center space-x-2">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Simpan Perubahan</span>
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
