<div class="w-full mx-auto">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-emerald-100">
        <!-- Header -->
        <div class="bg-gradient-to-r from-emerald-50 to-emerald-100 px-6 py-8 border-b border-emerald-200">
            <h2 class="text-3xl font-bold text-emerald-800">Profil Admin</h2>
            <p class="text-emerald-600 mt-1">Kelola data profil dan akun admin</p>
        </div>

        <div class="px-6 py-8">
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

            <form wire:submit.prevent="updateProfil" class="flex flex-col gap-8">

                <!-- Informasi Admin -->
                <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="h-5 w-5 text-blue-500 mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        Informasi Admin
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Username -->
                        <div>
                            <x-label for="username" value="Username" class="text-sm font-medium text-gray-700" />
                            <x-input id="username" wire:model.defer="username"
                                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                placeholder="Masukkan username" />
                            @error('username')
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Email -->
                        <div>
                            <x-label for="email" value="Email" class="text-sm font-medium text-gray-700" />
                            <x-input id="email" type="email" wire:model.defer="email"
                                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                placeholder="contoh@email.com" />
                            @error('email')
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- No Telepon -->
                        <div>
                            <x-label for="notlp" value="No Telepon (Opsional)"
                                class="text-sm font-medium text-gray-700" />
                            <x-input id="notlp" wire:model.defer="notlp"
                                class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                placeholder="Masukkan no telepon admin" />
                            @error('notlp')
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Password -->
                <div class="bg-indigo-50 rounded-xl p-6 border border-indigo-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                        Password Admin
                    </h3>
                    <div class="grid grid-cols-1">
                        <div>
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
