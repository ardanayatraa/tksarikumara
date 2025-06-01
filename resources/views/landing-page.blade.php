<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TK Sari Kumara - Pendidikan Anak Usia Dini Berkualitas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2E7D32',
                        secondary: '#4CAF50',
                        accent: '#66BB6A',
                        light: '#F1F8E9',
                        dark: '#1B5E20',
                        gold: '#FFD700',
                    },
                    fontFamily: {
                        'elegant': ['Playfair Display', 'serif'],
                        'body': ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            scroll-behavior: smooth;
        }

        .elegant-shadow {
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .luxury-card {
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hero-bg {
            background: linear-gradient(135deg, #F1F8E9 0%, #E8F5E9 100%);
        }

        .section-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #2E7D32, transparent);
        }

        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .luxury-border {
            border: 2px solid transparent;
            background: linear-gradient(white, white) padding-box,
                linear-gradient(45deg, #2E7D32, #4CAF50) border-box;
        }
    </style>
</head>

<body class="bg-white">
    <!-- Navigation -->
    <nav class="bg-white/95 backdrop-blur-md shadow-lg fixed w-full z-50 border-b border-gray-100">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4" data-aos="fade-right">
                    <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                        </svg>
                    </div>
                    <div>
                        <div class="font-elegant text-2xl font-bold text-primary">TK SARI KUMARA</div>
                        <div class="text-xs text-gray-600 font-medium">Excellence in Early Education</div>
                    </div>
                </div>
                <div class="hidden lg:flex space-x-8" data-aos="fade-left">
                    <a href="#beranda"
                        class="text-gray-700 hover:text-primary transition-all duration-300 font-medium relative group">
                        Beranda
                        <span
                            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#profil"
                        class="text-gray-700 hover:text-primary transition-all duration-300 font-medium relative group">
                        Profil
                        <span
                            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#visi-misi"
                        class="text-gray-700 hover:text-primary transition-all duration-300 font-medium relative group">
                        Visi & Misi
                        <span
                            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#tujuan"
                        class="text-gray-700 hover:text-primary transition-all duration-300 font-medium relative group">
                        Tujuan
                        <span
                            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#pendaftaran"
                        class="text-gray-700 hover:text-primary transition-all duration-300 font-medium relative group">
                        Pendaftaran
                        <span
                            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#fasilitas"
                        class="text-gray-700 hover:text-primary transition-all duration-300 font-medium relative group">
                        Fasilitas
                        <span
                            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#program"
                        class="text-gray-700 hover:text-primary transition-all duration-300 font-medium relative group">
                        Program
                        <span
                            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#kontak"
                        class="bg-primary hover:bg-secondary text-white px-6 py-2 rounded-full transition-all duration-300 font-medium shadow-lg hover:shadow-xl">
                        Kontak
                    </a>
                </div>
                <div class="lg:hidden">
                    <button id="menu-toggle" class="focus:outline-none">
                        <svg class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden lg:hidden bg-white/95 backdrop-blur-md border-t border-gray-100">
            <div class="container mx-auto px-6 py-4 space-y-4">
                <a href="#beranda"
                    class="block text-gray-700 hover:text-primary transition-all duration-300 font-medium py-2">Beranda</a>
                <a href="#profil"
                    class="block text-gray-700 hover:text-primary transition-all duration-300 font-medium py-2">Profil</a>
                <a href="#visi-misi"
                    class="block text-gray-700 hover:text-primary transition-all duration-300 font-medium py-2">Visi &
                    Misi</a>
                <a href="#tujuan"
                    class="block text-gray-700 hover:text-primary transition-all duration-300 font-medium py-2">Tujuan</a>
                <a href="#pendaftaran"
                    class="block text-gray-700 hover:text-primary transition-all duration-300 font-medium py-2">Pendaftaran</a>
                <a href="#fasilitas"
                    class="block text-gray-700 hover:text-primary transition-all duration-300 font-medium py-2">Fasilitas</a>
                <a href="#program"
                    class="block text-gray-700 hover:text-primary transition-all duration-300 font-medium py-2">Program</a>
                <a href="#kontak"
                    class="block text-gray-700 hover:text-primary transition-all duration-300 font-medium py-2">Kontak</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="hero-bg pt-32 pb-20 min-h-screen flex items-center">
        <div class="container mx-auto px-6">
            <div class="flex flex-col lg:flex-row items-center">
                <div class="lg:w-1/2 mb-12 lg:mb-0" data-aos="fade-right" data-aos-duration="1000">
                    <div class="mb-6">
                        <span
                            class="inline-block bg-white/80 text-primary px-4 py-2 rounded-full text-sm font-semibold mb-4 shadow-md">
                            ✨ Terakreditasi B & ISO 9001:2000
                        </span>
                    </div>
                    <h1 class="font-elegant text-5xl lg:text-6xl font-bold text-primary mb-6 leading-tight">
                        Selamat Datang di
                        <span class="text-secondary">TK Sari Kumara</span>
                    </h1>
                    <p class="text-xl text-gray-700 mb-8 leading-relaxed font-light">
                        Tempat terbaik untuk pendidikan anak usia dini yang cerdas, mandiri, dan berkarakter dengan
                        standar pendidikan berkualitas tinggi.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#pendaftaran"
                            class="bg-primary hover:bg-secondary text-white font-semibold py-4 px-8 rounded-full transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 text-center">
                            Daftar Sekarang
                        </a>
                        <a href="#profil"
                            class="border-2 border-primary text-primary hover:bg-primary hover:text-white font-semibold py-4 px-8 rounded-full transition-all duration-300 text-center">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
                <div class="lg:w-1/2 flex justify-center" data-aos="fade-left" data-aos-duration="1000"
                    data-aos-delay="200">
                    <div class="relative">
                        <div class="bg-white p-8 rounded-3xl shadow-2xl floating-animation">
                            <svg class="w-80 h-80 lg:w-96 lg:h-96" viewBox="0 0 400 400"
                                xmlns="http://www.w3.org/2000/svg">
                                <!-- Background Circle -->
                                <circle cx="200" cy="200" r="180" fill="#F1F8E9" stroke="#2E7D32"
                                    stroke-width="4" />

                                <!-- School Building -->
                                <rect x="120" y="180" width="160" height="120" fill="#2E7D32" rx="8" />
                                <rect x="130" y="190" width="140" height="100" fill="#4CAF50" rx="4" />

                                <!-- Roof -->
                                <polygon points="110,180 200,120 290,180" fill="#1B5E20" />

                                <!-- Windows -->
                                <rect x="140" y="200" width="30" height="30" fill="#E8F5E9" rx="4" />
                                <rect x="180" y="200" width="30" height="30" fill="#E8F5E9" rx="4" />
                                <rect x="220" y="200" width="30" height="30" fill="#E8F5E9" rx="4" />

                                <!-- Door -->
                                <rect x="185" y="240" width="30" height="50" fill="#1B5E20" rx="4" />
                                <circle cx="205" cy="265" r="2" fill="#FFD700" />

                                <!-- Flag -->
                                <rect x="195" y="120" width="3" height="40" fill="#8D6E63" />
                                <rect x="198" y="120" width="25" height="15" fill="#F44336" />
                                <rect x="198" y="135" width="25" height="15" fill="#FFFFFF" />

                                <!-- Trees -->
                                <circle cx="80" cy="250" r="25" fill="#66BB6A" />
                                <rect x="75" y="250" width="10" height="30" fill="#8D6E63" />

                                <circle cx="320" cy="250" r="25" fill="#66BB6A" />
                                <rect x="315" y="250" width="10" height="30" fill="#8D6E63" />

                                <!-- Children figures -->
                                <circle cx="150" cy="320" r="8" fill="#FFAB91" />
                                <rect x="145" y="328" width="10" height="20" fill="#2196F3" />

                                <circle cx="180" cy="320" r="8" fill="#FFAB91" />
                                <rect x="175" y="328" width="10" height="20" fill="#E91E63" />

                                <circle cx="220" cy="320" r="8" fill="#FFAB91" />
                                <rect x="215" y="328" width="10" height="20" fill="#FF9800" />

                                <circle cx="250" cy="320" r="8" fill="#FFAB91" />
                                <rect x="245" y="328" width="10" height="20" fill="#9C27B0" />
                            </svg>
                        </div>
                        <!-- Decorative elements -->
                        <div class="absolute -top-4 -right-4 w-8 h-8 bg-gold rounded-full animate-pulse"></div>
                        <div class="absolute -bottom-4 -left-4 w-6 h-6 bg-secondary rounded-full animate-pulse"
                            style="animation-delay: 1s;"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Profil Section -->
    <section id="profil" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="font-elegant text-4xl lg:text-5xl font-bold text-primary mb-4">Profil Sekolah</h2>
                <div class="section-divider w-24 mx-auto mb-6"></div>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">Mengenal lebih dekat TK Sari Kumara yang telah
                    dipercaya masyarakat sejak 2012</p>
            </div>
            <div class="bg-white luxury-border rounded-3xl p-8 lg:p-12 elegant-shadow" data-aos="fade-up"
                data-aos-delay="200">
                <div class="grid lg:grid-cols-3 gap-8 items-center">
                    <div class="lg:col-span-2">
                        <p class="text-gray-700 leading-relaxed text-lg mb-6">
                            TK SARI KUMARA adalah Taman Kanak-Kanak swasta di bawah naungan Kementerian Pendidikan dan
                            Kebudayaan yang berdiri sejak <span class="font-semibold text-primary">15 Desember
                                2012</span>. Beralamat di Jl. Satelit No. 54, Dauh Puri Klod, Denpasar Barat, Kota
                            Denpasar, Bali.
                        </p>
                        <p class="text-gray-700 leading-relaxed text-lg">
                            Sekolah ini telah <span class="font-semibold text-primary">terakreditasi B</span> dan
                            mengantongi <span class="font-semibold text-primary">sertifikasi ISO 9001:2000</span>.
                            Dengan tenaga pengajar berkompeten, TK SARI KUMARA menciptakan suasana belajar yang
                            menyenangkan, aman, dan edukatif bagi anak usia dini.
                        </p>
                    </div>
                    <div class="flex flex-col space-y-4">
                        <div class="bg-light p-6 rounded-2xl text-center">
                            <div class="text-3xl font-bold text-primary">13+</div>
                            <div class="text-gray-600 font-medium">Tahun Pengalaman</div>
                        </div>
                        <div class="bg-light p-6 rounded-2xl text-center">
                            <div class="text-3xl font-bold text-primary">B</div>
                            <div class="text-gray-600 font-medium">Akreditasi</div>
                        </div>
                        <div class="bg-light p-6 rounded-2xl text-center">
                            <div class="text-2xl font-bold text-primary">ISO</div>
                            <div class="text-gray-600 font-medium">9001:2000</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Visi Misi Section -->
    <section id="visi-misi" class="py-20 bg-light">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="font-elegant text-4xl lg:text-5xl font-bold text-primary mb-4">Visi & Misi</h2>
                <div class="section-divider w-24 mx-auto mb-6"></div>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">Komitmen kami dalam membentuk generasi anak usia
                    dini yang berkualitas</p>
            </div>
            <div class="grid lg:grid-cols-2 gap-8">
                <div class="bg-white rounded-3xl p-8 lg:p-12 elegant-shadow" data-aos="fade-right"
                    data-aos-delay="200">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-primary rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="font-elegant text-3xl font-bold text-primary">Visi</h3>
                    </div>
                    <blockquote class="border-l-4 border-primary pl-6 italic text-gray-700 text-lg leading-relaxed">
                        "Mewujudkan generasi anak usia dini yang cerdas, mandiri, berkarakter, dan berlandaskan
                        nilai-nilai kebangsaan serta budaya lokal."
                    </blockquote>
                </div>
                <div class="bg-white rounded-3xl p-8 lg:p-12 elegant-shadow" data-aos="fade-left"
                    data-aos-delay="400">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-secondary rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="font-elegant text-3xl font-bold text-primary">Misi</h3>
                    </div>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <div class="w-2 h-2 bg-primary rounded-full mt-3 mr-4 flex-shrink-0"></div>
                            <span class="text-gray-700 text-lg">Menyediakan lingkungan pembelajaran yang aman dan
                                nyaman.</span>
                        </li>
                        <li class="flex items-start">
                            <div class="w-2 h-2 bg-primary rounded-full mt-3 mr-4 flex-shrink-0"></div>
                            <span class="text-gray-700 text-lg">Mengembangkan aspek perkembangan anak secara
                                menyeluruh.</span>
                        </li>
                        <li class="flex items-start">
                            <div class="w-2 h-2 bg-primary rounded-full mt-3 mr-4 flex-shrink-0"></div>
                            <span class="text-gray-700 text-lg">Menanamkan nilai moral dan karakter sejak usia
                                dini.</span>
                        </li>
                        <li class="flex items-start">
                            <div class="w-2 h-2 bg-primary rounded-full mt-3 mr-4 flex-shrink-0"></div>
                            <span class="text-gray-700 text-lg">Melibatkan orang tua secara aktif dalam proses
                                pendidikan anak.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Tujuan Section -->
    <section id="tujuan" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="font-elegant text-4xl lg:text-5xl font-bold text-primary mb-4">Tujuan Sekolah</h2>
                <div class="section-divider w-24 mx-auto mb-6"></div>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">Mengembangkan potensi psikis dan fisik anak secara
                    optimal dan menyeluruh</p>
            </div>
            <div class="bg-white luxury-border rounded-3xl p-8 lg:p-12 elegant-shadow" data-aos="fade-up"
                data-aos-delay="200">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                    <div class="bg-light p-6 rounded-2xl text-center hover:bg-primary hover:text-white transition-all duration-300 group"
                        data-aos="fade-up" data-aos-delay="300">
                        <div
                            class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-white/20 transition-all duration-300">
                            <svg class="w-8 h-8 text-primary group-hover:text-white transition-all duration-300"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-lg mb-2">Nilai Agama</h4>
                        <p class="text-sm opacity-80">dan Moral</p>
                    </div>
                    <div class="bg-light p-6 rounded-2xl text-center hover:bg-primary hover:text-white transition-all duration-300 group"
                        data-aos="fade-up" data-aos-delay="400">
                        <div
                            class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-white/20 transition-all duration-300">
                            <svg class="w-8 h-8 text-primary group-hover:text-white transition-all duration-300"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-lg mb-2">Fisik</h4>
                        <p class="text-sm opacity-80">Motorik</p>
                    </div>
                    <div class="bg-light p-6 rounded-2xl text-center hover:bg-primary hover:text-white transition-all duration-300 group"
                        data-aos="fade-up" data-aos-delay="500">
                        <div
                            class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-white/20 transition-all duration-300">
                            <svg class="w-8 h-8 text-primary group-hover:text-white transition-all duration-300"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-lg mb-2">Sosial</h4>
                        <p class="text-sm opacity-80">Emosional</p>
                    </div>
                    <div class="bg-light p-6 rounded-2xl text-center hover:bg-primary hover:text-white transition-all duration-300 group"
                        data-aos="fade-up" data-aos-delay="600">
                        <div
                            class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-white/20 transition-all duration-300">
                            <svg class="w-8 h-8 text-primary group-hover:text-white transition-all duration-300"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-lg mb-2">Bahasa</h4>
                        <p class="text-sm opacity-80">Komunikasi</p>
                    </div>
                    <div class="bg-light p-6 rounded-2xl text-center hover:bg-primary hover:text-white transition-all duration-300 group"
                        data-aos="fade-up" data-aos-delay="700">
                        <div
                            class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-white/20 transition-all duration-300">
                            <svg class="w-8 h-8 text-primary group-hover:text-white transition-all duration-300"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-lg mb-2">Seni</h4>
                        <p class="text-sm opacity-80">Kreativitas</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pendaftaran Section -->
    <section id="pendaftaran" class="py-20 bg-light">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="font-elegant text-4xl lg:text-5xl font-bold text-primary mb-4">Info Pendaftaran</h2>
                <div class="section-divider w-24 mx-auto mb-6"></div>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">Bergabunglah dengan keluarga besar TK Sari Kumara
                    untuk masa depan anak yang cerah</p>
            </div>
            <div class="bg-white rounded-3xl p-8 lg:p-12 elegant-shadow" data-aos="fade-up" data-aos-delay="200">
                <div class="text-center mb-8">
                    <div
                        class="inline-flex items-center bg-gold/20 text-primary px-6 py-3 rounded-full text-lg font-bold mb-4">
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                                clip-rule="evenodd" />
                        </svg>
                        Gratis Biaya Pendaftaran
                    </div>
                </div>
                <div class="grid lg:grid-cols-2 gap-12">
                    <div data-aos="fade-right" data-aos-delay="300">
                        <h3 class="font-elegant text-2xl font-bold text-primary mb-6 flex items-center">
                            <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                    clip-rule="evenodd" />
                            </svg>
                            Syarat Pendaftaran
                        </h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div
                                    class="w-6 h-6 bg-primary rounded-full flex items-center justify-center mr-4 mt-1 flex-shrink-0">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-gray-700 text-lg">Mengisi formulir pendaftaran</span>
                            </div>
                            <div class="flex items-start">
                                <div
                                    class="w-6 h-6 bg-primary rounded-full flex items-center justify-center mr-4 mt-1 flex-shrink-0">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-gray-700 text-lg">Menyerahkan fotokopi kartu keluarga dan akta
                                    kelahiran anak (1 lembar)</span>
                            </div>
                        </div>
                    </div>
                    <div data-aos="fade-left" data-aos-delay="400">
                        <h3 class="font-elegant text-2xl font-bold text-primary mb-6 flex items-center">
                            <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                            </svg>
                            Kelompok Usia
                        </h3>
                        <div class="space-y-4">
                            <div class="bg-light p-6 rounded-2xl">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-bold text-lg text-primary">Kelompok A</h4>
                                        <p class="text-gray-600">Usia 4–5 tahun</p>
                                    </div>
                                    <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center">
                                        <span class="text-white font-bold text-xl">A</span>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-light p-6 rounded-2xl">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-bold text-lg text-primary">Kelompok B</h4>
                                        <p class="text-gray-600">Usia 5–6 tahun</p>
                                    </div>
                                    <div class="w-12 h-12 bg-secondary rounded-full flex items-center justify-center">
                                        <span class="text-white font-bold text-xl">B</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-12 text-center" data-aos="fade-up" data-aos-delay="500">
                    <button id="daftar-btn"
                        class="bg-primary hover:bg-secondary text-white font-bold py-4 px-8 rounded-full transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 text-lg">
                        Daftar Sekarang
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Fasilitas Section -->
    <section id="fasilitas" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="font-elegant text-4xl lg:text-5xl font-bold text-primary mb-4">Fasilitas</h2>
                <div class="section-divider w-24 mx-auto mb-6"></div>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">Fasilitas lengkap dan modern untuk mendukung proses
                    pembelajaran yang optimal</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                <div class="bg-white luxury-border rounded-2xl p-6 text-center hover:shadow-2xl transition-all duration-300 group"
                    data-aos="fade-up" data-aos-delay="200">
                    <div
                        class="w-20 h-20 bg-primary rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-secondary transition-all duration-300">
                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg text-primary mb-2">Gedung Milik</h3>
                    <p class="text-gray-600 text-sm">Br. Bumi Sari</p>
                </div>
                <div class="bg-white luxury-border rounded-2xl p-6 text-center hover:shadow-2xl transition-all duration-300 group"
                    data-aos="fade-up" data-aos-delay="300">
                    <div
                        class="w-20 h-20 bg-primary rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-secondary transition-all duration-300">
                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg text-primary mb-2">Ruang Belajar</h3>
                    <p class="text-gray-600 text-sm">Nyaman & Kondusif</p>
                </div>
                <div class="bg-white luxury-border rounded-2xl p-6 text-center hover:shadow-2xl transition-all duration-300 group"
                    data-aos="fade-up" data-aos-delay="400">
                    <div
                        class="w-20 h-20 bg-primary rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-secondary transition-all duration-300">
                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg text-primary mb-2">Alat Bermain</h3>
                    <p class="text-gray-600 text-sm">Edukatif & Aman</p>
                </div>
                <div class="bg-white luxury-border rounded-2xl p-6 text-center hover:shadow-2xl transition-all duration-300 group"
                    data-aos="fade-up" data-aos-delay="500">
                    <div
                        class="w-20 h-20 bg-primary rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-secondary transition-all duration-300">
                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg text-primary mb-2">Area Bermain</h3>
                    <p class="text-gray-600 text-sm">Luas & Aman</p>
                </div>
                <div class="bg-white luxury-border rounded-2xl p-6 text-center hover:shadow-2xl transition-all duration-300 group"
                    data-aos="fade-up" data-aos-delay="600">
                    <div
                        class="w-20 h-20 bg-primary rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-secondary transition-all duration-300">
                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg text-primary mb-2">Toilet</h3>
                    <p class="text-gray-600 text-sm">Bersih & Higienis</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Program Section -->
    <section id="program" class="py-20 bg-light">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="font-elegant text-4xl lg:text-5xl font-bold text-primary mb-4">Program Unggulan</h2>
                <div class="section-divider w-24 mx-auto mb-6"></div>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">Program ekstrakurikuler yang dirancang khusus untuk
                    mengembangkan bakat dan minat anak</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white rounded-3xl p-8 text-center hover:shadow-2xl transition-all duration-300 group elegant-shadow"
                    data-aos="fade-up" data-aos-delay="200">
                    <div
                        class="w-24 h-24 bg-primary rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:bg-secondary transition-all duration-300">
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                        </svg>
                    </div>
                    <h3 class="font-elegant text-2xl font-bold text-primary mb-3">Muatan Lokal</h3>
                    <p class="text-gray-600 text-lg mb-4">Bahasa Bali</p>
                    <p class="text-gray-500 text-sm">Melestarikan budaya lokal Bali melalui pembelajaran bahasa daerah
                    </p>
                </div>
                <div class="bg-white rounded-3xl p-8 text-center hover:shadow-2xl transition-all duration-300 group elegant-shadow"
                    data-aos="fade-up" data-aos-delay="300">
                    <div
                        class="w-24 h-24 bg-primary rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:bg-secondary transition-all duration-300">
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                        </svg>
                    </div>
                    <h3 class="font-elegant text-2xl font-bold text-primary mb-3">Ekstra Menari</h3>
                    <p class="text-gray-600 text-lg mb-4">Tarian Tradisional</p>
                    <p class="text-gray-500 text-sm">Mengembangkan keterampilan gerak dan apresiasi seni budaya</p>
                </div>
                <div class="bg-white rounded-3xl p-8 text-center hover:shadow-2xl transition-all duration-300 group elegant-shadow"
                    data-aos="fade-up" data-aos-delay="400">
                    <div
                        class="w-24 h-24 bg-primary rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:bg-secondary transition-all duration-300">
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="font-elegant text-2xl font-bold text-primary mb-3">Ekstra Menggambar</h3>
                    <p class="text-gray-600 text-lg mb-4">Pengembangan Kreativitas</p>
                    <p class="text-gray-500 text-sm">Melatih imajinasi dan kemampuan motorik halus anak</p>
                </div>
                <div class="bg-white rounded-3xl p-8 text-center hover:shadow-2xl transition-all duration-300 group elegant-shadow"
                    data-aos="fade-up" data-aos-delay="500">
                    <div
                        class="w-24 h-24 bg-primary rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:bg-secondary transition-all duration-300">
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="font-elegant text-2xl font-bold text-primary mb-3">Ekstra Berenang</h3>
                    <p class="text-gray-600 text-lg mb-4">Pengembangan Motorik</p>
                    <p class="text-gray-500 text-sm">Meningkatkan kesehatan dan kemampuan motorik kasar</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Kontak Section -->
    <section id="kontak" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="font-elegant text-4xl lg:text-5xl font-bold text-primary mb-4">Kontak Sekolah</h2>
                <div class="section-divider w-24 mx-auto mb-6"></div>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">Hubungi kami untuk informasi lebih lanjut atau
                    kunjungi langsung sekolah kami</p>
            </div>
            <div class="grid lg:grid-cols-2 gap-12">
                <div class="bg-white luxury-border rounded-3xl p-8 lg:p-12 elegant-shadow" data-aos="fade-right"
                    data-aos-delay="200">
                    <h3 class="font-elegant text-3xl font-bold text-primary mb-8">Informasi Kontak</h3>
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div
                                class="w-12 h-12 bg-primary rounded-2xl flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg text-primary mb-1">Alamat</h4>
                                <p class="text-gray-700">Jl. Satelit No. 54, Br. Bumi Sari, Dauh Puri Klod, Denpasar
                                    Barat</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div
                                class="w-12 h-12 bg-primary rounded-2xl flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg text-primary mb-1">Email</h4>
                                <p class="text-gray-700">tksarikumara2021@gmail.com</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div
                                class="w-12 h-12 bg-primary rounded-2xl flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg text-primary mb-1">Kepala Sekolah</h4>
                                <p class="text-gray-700">Stella Rosari Indrieswari</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div
                                class="w-12 h-12 bg-primary rounded-2xl flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg text-primary mb-1">Operator Sekolah</h4>
                                <p class="text-gray-700">Luh Gde Sari Puspadewi</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white luxury-border rounded-3xl p-8 lg:p-12 elegant-shadow" data-aos="fade-left"
                    data-aos-delay="400">
                    <h3 class="font-elegant text-3xl font-bold text-primary mb-8">Kirim Pesan</h3>
                    <form id="contact-form" class="space-y-6">
                        <div>
                            <label for="name" class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                            <input type="text" id="name"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300">
                        </div>
                        <div>
                            <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                            <input type="email" id="email"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300">
                        </div>
                        <div>
                            <label for="phone" class="block text-gray-700 font-medium mb-2">Nomor Telepon</label>
                            <input type="tel" id="phone"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300">
                        </div>
                        <div>
                            <label for="message" class="block text-gray-700 font-medium mb-2">Pesan</label>
                            <textarea id="message" rows="5"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 resize-none"></textarea>
                        </div>
                        <button type="submit"
                            class="w-full bg-primary hover:bg-secondary text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-primary text-white py-16">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-3 gap-8 mb-8">
                <div data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-elegant text-2xl font-bold">TK SARI KUMARA</h3>
                            <p class="text-white/80">Excellence in Early Education</p>
                        </div>
                    </div>
                    <p class="text-white/80 leading-relaxed">
                        Pendidikan anak usia dini berkualitas dengan standar internasional, mengembangkan potensi anak
                        secara optimal dalam lingkungan yang aman dan menyenangkan.
                    </p>
                </div>
                <div data-aos="fade-up" data-aos-delay="300">
                    <h4 class="font-bold text-xl mb-6">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="#profil"
                                class="text-white/80 hover:text-white transition-all duration-300">Profil Sekolah</a>
                        </li>
                        <li><a href="#visi-misi"
                                class="text-white/80 hover:text-white transition-all duration-300">Visi & Misi</a></li>
                        <li><a href="#pendaftaran"
                                class="text-white/80 hover:text-white transition-all duration-300">Pendaftaran</a></li>
                        <li><a href="#fasilitas"
                                class="text-white/80 hover:text-white transition-all duration-300">Fasilitas</a></li>
                        <li><a href="#program"
                                class="text-white/80 hover:text-white transition-all duration-300">Program Unggulan</a>
                        </li>
                    </ul>
                </div>
                <div data-aos="fade-up" data-aos-delay="400">
                    <h4 class="font-bold text-xl mb-6">Jam Operasional</h4>
                    <div class="space-y-3 text-white/80">
                        <div class="flex justify-between">
                            <span>Senin - Jumat</span>
                            <span>07:00 - 11:00</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Sabtu</span>
                            <span>07:00 - 10:00</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Minggu</span>
                            <span>Tutup</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-t border-white/20 pt-8">
                <div class="flex flex-col lg:flex-row justify-between items-center">
                    <p class="text-white/80 mb-4 lg:mb-0">&copy; 2025 TK Sari Kumara. Hak Cipta Dilindungi
                        Undang-Undang.</p>
                    <div class="flex space-x-6">
                        <span class="text-white/60">Terakreditasi B</span>
                        <span class="text-white/60">•</span>
                        <span class="text-white/60">ISO 9001:2000</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="back-to-top"
        class="fixed bottom-8 right-8 bg-primary hover:bg-secondary text-white w-14 h-14 rounded-full flex items-center justify-center shadow-2xl transition-all duration-300 transform hover:-translate-y-1 hidden z-40">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
    </button>

    <!-- Modal Pendaftaran -->
    <div id="modal"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-3xl p-8 max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto elegant-shadow"
            data-aos="zoom-in">
            <div class="flex justify-between items-center mb-8">
                <h3 class="font-elegant text-3xl font-bold text-primary">Formulir Pendaftaran</h3>
                <button id="close-modal" class="text-gray-500 hover:text-gray-700 transition-all duration-300">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            <form id="registration-form" class="space-y-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="child-name" class="block text-gray-700 font-medium mb-2">Nama Anak</label>
                        <input type="text" id="child-name"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300"
                            required>
                    </div>
                    <div>
                        <label for="birth-date" class="block text-gray-700 font-medium mb-2">Tanggal Lahir</label>
                        <input type="date" id="birth-date"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300"
                            required>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="parent-name" class="block text-gray-700 font-medium mb-2">Nama Orang Tua</label>
                        <input type="text" id="parent-name"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300"
                            required>
                    </div>
                    <div>
                        <label for="phone" class="block text-gray-700 font-medium mb-2">Nomor Telepon</label>
                        <input type="tel" id="phone"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300"
                            required>
                    </div>
                </div>
                <div>
                    <label for="address" class="block text-gray-700 font-medium mb-2">Alamat Lengkap</label>
                    <textarea id="address" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 resize-none"
                        required></textarea>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-4">Pilih Kelompok</label>
                    <div class="grid md:grid-cols-2 gap-4">
                        <label
                            class="flex items-center p-4 border border-gray-300 rounded-xl cursor-pointer hover:border-primary transition-all duration-300">
                            <input type="radio" name="group" value="A"
                                class="mr-3 text-primary focus:ring-primary">
                            <div>
                                <span class="font-semibold text-primary">Kelompok A</span>
                                <p class="text-gray-600 text-sm">Usia 4-5 tahun</p>
                            </div>
                        </label>
                        <label
                            class="flex items-center p-4 border border-gray-300 rounded-xl cursor-pointer hover:border-primary transition-all duration-300">
                            <input type="radio" name="group" value="B"
                                class="mr-3 text-primary focus:ring-primary">
                            <div>
                                <span class="font-semibold text-primary">Kelompok B</span>
                                <p class="text-gray-600 text-sm">Usia 5-6 tahun</p>
                            </div>
                        </label>
                    </div>
                </div>
                <button type="submit"
                    class="w-full bg-primary hover:bg-secondary text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    Kirim Pendaftaran
                </button>
            </form>
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
            offset: 100
        });

        // Mobile Menu Toggle
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Smooth Scrolling for Anchor Links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                }

                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Back to Top Button
        const backToTopButton = document.getElementById('back-to-top');

        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 500) {
                backToTopButton.classList.remove('hidden');
            } else {
                backToTopButton.classList.add('hidden');
            }
        });

        backToTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Modal Functionality
        const modal = document.getElementById('modal');
        const daftarBtn = document.getElementById('daftar-btn');
        const closeModal = document.getElementById('close-modal');

        daftarBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });

        closeModal.addEventListener('click', () => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        });

        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        });

        // Form Submissions
        const contactForm = document.getElementById('contact-form');
        const registrationForm = document.getElementById('registration-form');

        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();

            // Show success message
            const button = e.target.querySelector('button[type="submit"]');
            const originalText = button.textContent;
            button.textContent = 'Terkirim ✓';
            button.classList.add('bg-green-500');

            setTimeout(() => {
                button.textContent = originalText;
                button.classList.remove('bg-green-500');
                contactForm.reset();
            }, 2000);
        });

        registrationForm.addEventListener('submit', (e) => {
            e.preventDefault();

            // Show success message
            const button = e.target.querySelector('button[type="submit"]');
            const originalText = button.textContent;
            button.textContent = 'Pendaftaran Berhasil ✓';
            button.classList.add('bg-green-500');

            setTimeout(() => {
                button.textContent = originalText;
                button.classList.remove('bg-green-500');
                registrationForm.reset();
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 2000);
        });

        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('nav');
            if (window.scrollY > 100) {
                navbar.classList.add('bg-white/98');
                navbar.classList.remove('bg-white/95');
            } else {
                navbar.classList.add('bg-white/95');
                navbar.classList.remove('bg-white/98');
            }
        });
    </script>
</body>

</html>
