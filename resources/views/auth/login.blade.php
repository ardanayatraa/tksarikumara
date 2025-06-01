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
                            light: '#E8F5E9',
                            DEFAULT: '#4CAF50',
                            dark: '#2E7D32',
                        },
                        secondary: {
                            light: '#F1F8E9',
                            DEFAULT: '#8BC34A',
                            dark: '#558B2F',
                        },
                        gold: '#FFD700',
                    },
                    fontFamily: {
                        'elegant': ['Playfair Display', 'serif'],
                        'body': ['Inter', 'sans-serif'],
                    }
                },
            },
        }
    </script>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%234CAF50' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .elegant-shadow {
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .luxury-border {
            border: 2px solid transparent;
            background: linear-gradient(white, white) padding-box,
                linear-gradient(45deg, #2E7D32, #4CAF50) border-box;
        }
    </style>
</head>

<body class="font-body min-h-screen flex items-center justify-center p-4 bg-primary-light/10">
    <div class="bg-white rounded-3xl luxury-border elegant-shadow w-full max-w-md p-10 relative overflow-hidden"
        data-aos="fade-up" data-aos-duration="800">
        <!-- Decorative elements -->
        <div class="absolute -top-20 -left-20 w-48 h-48 bg-primary-light rounded-full opacity-50"></div>
        <div class="absolute -bottom-20 -right-20 w-48 h-48 bg-secondary-light rounded-full opacity-50"></div>

        <div class="relative">
            <!-- Logo and Header -->
            <div class="text-center mb-10" data-aos="fade-down" data-aos-delay="200">
                <div class="w-24 h-24 bg-primary rounded-full mx-auto mb-6 flex items-center justify-center shadow-lg">
                    <span class="text-3xl font-bold text-white font-elegant">TK</span>
                </div>
                <h1 class="text-3xl font-bold text-primary-dark font-elegant">TK Sari Kumara</h1>
                <p class="text-gray-600 mt-2">Silakan masuk ke akun Anda</p>
            </div>

            <!-- Login Form - Using Laravel conventions -->
            <form action="{{ route('login') }}" method="POST" class="space-y-6" data-aos="fade-up"
                data-aos-delay="400">
                @csrf

                <!-- Username Field -->
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                    <div class="relative">
                        <input type="text" id="username" name="username"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-300 @error('username') border-red-500 @enderror"
                            placeholder="Masukkan username" value="{{ old('username') }}" required autofocus>
                        @error('username')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-300 @error('password') border-red-500 @enderror"
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
                        class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50">
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

            <!-- Register Link -->
            <div class="mt-8 text-center" data-aos="fade-up" data-aos-delay="600">
                <p class="text-gray-600">Belum memiliki akun?</p>
                <a href="{{ route('register') }}"
                    class="text-primary-dark hover:text-primary font-medium transition-colors duration-300">
                    Daftar sekarang
                </a>
            </div>

            <!-- Footer -->
            <div class="mt-10 text-center text-sm text-gray-500" data-aos="fade-up" data-aos-delay="700">
                <p>© {{ date('Y') }} TK Sari Kumara. Semua hak dilindungi.</p>
            </div>
        </div>
    </div>

    <!-- AOS Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 50
        });
    </script>
</body>

</html>
