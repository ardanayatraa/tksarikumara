<x-guest-layout>
    <div
        class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-pink-100 via-yellow-100 to-blue-100 p-4">
        <div class="mb-6">
            <img src="{{ asset('images/tk-logo.png') }}" alt="Logo TK" class="w-24 h-24 rounded-full shadow-lg">
        </div>

        <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-8 border-4 border-yellow-300">
            <h2 class="text-3xl font-bold text-center text-pink-600 mb-6" style="font-family: 'Comic Sans MS', cursive;">
                Selamat Datang di TK Ceria
            </h2>

            <x-validation-errors class="mb-4 text-red-500" />

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <x-label for="username" value="Nama Pengguna" class="text-pink-700" />
                    <x-input id="username"
                        class="block mt-1 w-full rounded-full px-4 py-2 border-pink-300 focus:ring-pink-400"
                        type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
                </div>

                <div class="mt-4">
                    <x-label for="password" value="Kata Sandi" class="text-pink-700" />
                    <x-input id="password"
                        class="block mt-1 w-full rounded-full px-4 py-2 border-pink-300 focus:ring-pink-400"
                        type="password" name="password" required autocomplete="current-password" />
                </div>

                <div class="block mt-4">
                    <label for="remember_me" class="flex items-center text-sm text-pink-700">
                        <x-checkbox id="remember_me" name="remember" />
                        <span class="ms-2">Ingat saya</span>
                    </label>
                </div>

                <div class="flex items-center justify-between mt-6">
                    <x-button
                        class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded-full transition ease-in-out duration-300">
                        Masuk
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
