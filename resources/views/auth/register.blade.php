<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TK Sari Kumara - Pendaftaran</title>
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
    <div class="bg-white rounded-3xl luxury-border elegant-shadow w-full max-w-2xl p-10 relative overflow-hidden my-10"
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
                <p class="text-gray-600 mt-2">Daftar akun baru</p>
            </div>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl" data-aos="fade-up"
                    data-aos-delay="300">
                    <div class="font-medium">Terjadi kesalahan:</div>
                    <ul class="mt-2 text-sm list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Registration Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-6" data-aos="fade-up"
                data-aos-delay="400">
                @csrf

                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        autocomplete="name"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-300">
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        autocomplete="username"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-300">
                </div>

                <!-- Password Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-300">
                    </div>

                    <div>
                        <label for="password_confirmation"
                            class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            autocomplete="new-password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-300">
                    </div>
                </div>



                <div class="flex flex-col md:flex-row items-center justify-between gap-4 pt-4">
                    <a href="{{ route('login') }}"
                        class="text-primary-dark hover:text-primary font-medium transition-colors duration-300 text-center md:text-left w-full md:w-auto">
                        Sudah memiliki akun?
                    </a>

                    <button type="submit"
                        class="bg-primary hover:bg-primary-dark text-white font-bold py-3 px-8 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50 w-full md:w-auto">
                        Daftar
                    </button>
                </div>
            </form>

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
