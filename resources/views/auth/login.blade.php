<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TK Sari Kumara - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            light: '#FFB6C1', // Light pink
                            DEFAULT: '#FF69B4', // Hot pink
                            dark: '#C71585', // Medium violet red
                        },
                        secondary: {
                            light: '#ADD8E6', // Light blue
                            DEFAULT: '#87CEEB', // Sky blue
                            dark: '#4682B4', // Steel blue
                        },
                    },
                    fontFamily: {
                        sans: ['Nunito', 'sans-serif'],
                    },
                },
            },
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap');

        body {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23FFB6C1' fill-opacity='0.2'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>

<body class="font-sans min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-8 relative overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute -top-10 -left-10 w-40 h-40 bg-primary-light rounded-full opacity-20"></div>
        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-secondary-light rounded-full opacity-20"></div>

        <div class="relative">
            <!-- Logo and Header -->
            <div class="text-center mb-8">
                <div class="w-24 h-24 bg-primary-light rounded-full mx-auto mb-4 flex items-center justify-center">
                    <span class="text-3xl font-bold text-primary-dark">TK</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">TK Sari Kumara</h1>
                <p class="text-gray-500 mt-1">Silakan masuk ke akun Anda</p>
            </div>

            <!-- Login Form - Using Laravel conventions -->
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Username Field -->
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <div class="relative">
                        <input type="text" id="username" name="username"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors @error('username') border-red-500 @enderror"
                            placeholder="Masukkan username" value="{{ old('username') }}" required autofocus>
                        @error('username')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors @error('password') border-red-500 @enderror"
                            placeholder="Masukkan password" required>
                        @error('password')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember"
                        class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" class="ml-2 block text-sm text-gray-700">
                        Ingat saya
                    </label>
                </div>

                <!-- Login Button -->
                <div>
                    <button type="submit"
                        class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50">
                        Masuk
                    </button>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="text-center text-sm text-green-500">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Session Error -->
                @if (session('error'))
                    <div class="text-center text-sm text-red-500">
                        {{ session('error') }}
                    </div>
                @endif
            </form>

            <!-- Footer -->
            <div class="mt-6 text-center text-sm text-gray-500">
                <p>© {{ date('Y') }} TK Sari Kumara. Semua hak dilindungi.</p>
            </div>
        </div>
    </div>
</body>

</html>
