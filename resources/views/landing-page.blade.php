<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TK Sari Kumara Denpasar - Taman Kanak-Kanak Berkualitas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&family=Fredoka+One&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3498DB',
                        secondary: '#2ECC71',
                        accent: '#FF9800',
                        yellow: '#FFC312',
                        teal: '#1ABC9C',
                        orange: '#E67E22',
                        dark: '#2C3E50',
                    },
                    fontFamily: {
                        sans: ['Nunito', 'sans-serif'],
                        display: ['Fredoka One', 'cursive'],
                    },
                    boxShadow: {
                        'soft': '0 10px 25px -5px rgba(0, 0, 0, 0.05)',
                        'hover': '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
                    }
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
            .bg-dots {
                background-image: radial-gradient(#3498DB 2px, transparent 2px);
                background-size: 30px 30px;
                background-color: #f8fafc;
            }
        }
    </style>
</head>

<body class="font-sans bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white fixed w-full z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <div
                            class="h-12 w-12 rounded-lg bg-primary flex items-center justify-center text-white font-bold text-xl mr-3">
                            SK</div>
                        <span class="text-dark font-bold text-xl tracking-tight font-display">TK Sari Kumara</span>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center sm:hidden">
                    <button id="mobile-menu-button"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <!-- Desktop menu -->
                <div class="hidden sm:flex sm:items-center sm:space-x-8">
                    <a href="#beranda"
                        class="px-3 py-2 text-sm font-medium text-dark hover:text-primary transition-colors">Beranda</a>
                    <a href="#tentang"
                        class="px-3 py-2 text-sm font-medium text-dark hover:text-primary transition-colors">Tentang</a>
                    <a href="#program"
                        class="px-3 py-2 text-sm font-medium text-dark hover:text-primary transition-colors">Program</a>
                    <a href="#kontak"
                        class="px-3 py-2 text-sm font-medium text-dark hover:text-primary transition-colors">Kontak</a>
                    <a href="#masuk"
                        class="ml-2 px-6 py-2.5 rounded-full text-sm font-medium bg-primary text-white hover:bg-primary/90 transition-all duration-300">Masuk</a>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="sm:hidden hidden">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="#beranda"
                    class="block px-3 py-2 rounded-md text-base font-medium text-dark hover:text-primary">Beranda</a>
                <a href="#tentang"
                    class="block px-3 py-2 rounded-md text-base font-medium text-dark hover:text-primary">Tentang</a>
                <a href="#program"
                    class="block px-3 py-2 rounded-md text-base font-medium text-dark hover:text-primary">Program</a>
                <a href="#kontak"
                    class="block px-3 py-2 rounded-md text-base font-medium text-dark hover:text-primary">Kontak</a>
                <a href="#masuk"
                    class="block px-3 py-2 rounded-md text-base font-medium text-primary hover:text-secondary">Masuk</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section (Beranda) -->
    <section id="beranda" class="pt-32 pb-20 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-7 order-2 lg:order-1">
                    <div class="relative">
                        <div class="absolute -top-20 -left-20 w-64 h-64 bg-yellow/10 rounded-full"></div>
                        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-primary/10 rounded-full"></div>

                        <div class="relative">
                            <h1
                                class="text-4xl md:text-5xl lg:text-6xl font-bold text-dark mb-6 leading-tight font-display">
                                Tempat Terbaik Untuk <span class="text-primary">Tumbuh Kembang</span> Anak Anda
                            </h1>
                            <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                                TK Sari Kumara menyediakan lingkungan belajar yang menyenangkan dan edukatif untuk
                                membantu anak-anak mengembangkan potensi mereka secara maksimal.
                            </p>

                            <div class="flex flex-wrap gap-4">
                                <a href="#program"
                                    class="px-8 py-4 bg-primary text-white font-bold rounded-xl text-center hover:shadow-lg hover:bg-primary/90 transition-all duration-300">
                                    Lihat Program Kami
                                </a>
                                <a href="#kontak"
                                    class="px-8 py-4 border-2 border-secondary text-secondary font-bold rounded-xl text-center hover:bg-secondary hover:text-white transition-all duration-300">
                                    Hubungi Kami
                                </a>
                            </div>

                            <div class="mt-12 flex items-center space-x-8">
                                <div class="flex flex-col items-center">
                                    <span class="text-3xl font-bold text-primary">15+</span>
                                    <span class="text-gray-600 text-sm">Tahun Pengalaman</span>
                                </div>
                                <div class="h-12 border-l border-gray-200"></div>
                                <div class="flex flex-col items-center">
                                    <span class="text-3xl font-bold text-primary">50+</span>
                                    <span class="text-gray-600 text-sm">Pengajar Profesional</span>
                                </div>
                                <div class="h-12 border-l border-gray-200"></div>
                                <div class="flex flex-col items-center">
                                    <span class="text-3xl font-bold text-primary">1000+</span>
                                    <span class="text-gray-600 text-sm">Lulusan Sukses</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5 order-1 lg:order-2">
                    <div class="relative">
                        <div class="absolute inset-0 bg-secondary/20 rounded-full transform -rotate-6"></div>
                        <img src="https://images.unsplash.com/photo-1587691592099-24045742c181?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            alt="Anak-anak TK Sari Kumara" class="relative rounded-3xl shadow-soft w-full h-auto z-10">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-dots">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-dark mb-4 font-display">Mengapa Memilih TK Sari Kumara?
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">Kami menawarkan pendidikan berkualitas dengan
                    pendekatan yang menyenangkan untuk membantu anak-anak berkembang secara optimal.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                <div
                    class="bg-white p-8 rounded-3xl shadow-soft hover:shadow-hover transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-yellow/20 rounded-2xl flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-dark">Kurikulum Terpadu</h3>
                    <p class="text-gray-600 leading-relaxed">Menggabungkan kurikulum nasional dengan metode
                        pembelajaran modern untuk mengembangkan keterampilan kognitif, sosial, dan emosional anak.</p>
                </div>

                <div
                    class="bg-white p-8 rounded-3xl shadow-soft hover:shadow-hover transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-primary/20 rounded-2xl flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-dark">Guru Berpengalaman</h3>
                    <p class="text-gray-600 leading-relaxed">Tim pengajar kami terdiri dari profesional berpengalaman
                        yang memiliki dedikasi tinggi dalam pendidikan anak usia dini.</p>
                </div>

                <div
                    class="bg-white p-8 rounded-3xl shadow-soft hover:shadow-hover transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-secondary/20 rounded-2xl flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-secondary" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-dark">Fasilitas Lengkap</h3>
                    <p class="text-gray-600 leading-relaxed">Dilengkapi dengan ruang kelas nyaman, area bermain indoor
                        dan outdoor, perpustakaan, dan berbagai fasilitas pendukung lainnya.</p>
                </div>

                <div
                    class="bg-white p-8 rounded-3xl shadow-soft hover:shadow-hover transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-accent/20 rounded-2xl flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-accent" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-dark">Program Ekstrakurikuler</h3>
                    <p class="text-gray-600 leading-relaxed">Berbagai kegiatan tambahan seperti musik, tari, seni, dan
                        olahraga untuk mengembangkan bakat dan minat anak.</p>
                </div>

                <div
                    class="bg-white p-8 rounded-3xl shadow-soft hover:shadow-hover transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-teal/20 rounded-2xl flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-teal" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-dark">Program Bilingual</h3>
                    <p class="text-gray-600 leading-relaxed">Pembelajaran dalam Bahasa Indonesia dan Bahasa Inggris
                        untuk mempersiapkan anak menghadapi era global.</p>
                </div>

                <div
                    class="bg-white p-8 rounded-3xl shadow-soft hover:shadow-hover transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-orange/20 rounded-2xl flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-dark">Jam Belajar Fleksibel</h3>
                    <p class="text-gray-600 leading-relaxed">Menawarkan program half-day dan full-day untuk memenuhi
                        kebutuhan berbagai keluarga.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section (Tentang) -->
    <section id="tentang" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="order-2 lg:order-1">
                    <h5 class="text-primary font-bold mb-3 tracking-wider">TENTANG KAMI</h5>
                    <h2 class="text-3xl md:text-4xl font-bold text-dark mb-6 font-display">Sejarah dan Visi TK Sari
                        Kumara</h2>

                    <p class="text-gray-600 mb-6 leading-relaxed">
                        TK Sari Kumara didirikan pada tahun 2005 dengan visi menjadi lembaga pendidikan anak usia dini
                        terdepan yang menghasilkan generasi cerdas, kreatif, dan berkarakter.
                    </p>

                    <p class="text-gray-600 mb-8 leading-relaxed">
                        Selama lebih dari 15 tahun, kami telah mendedikasikan diri untuk memberikan pendidikan
                        berkualitas dengan pendekatan holistik yang mengintegrasikan perkembangan kognitif, sosial,
                        emosional, dan fisik anak.
                    </p>

                    <div class="space-y-4 mb-8">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div
                                    class="w-5 h-5 rounded-full bg-primary flex items-center justify-center text-white text-xs">
                                    ✓</div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-dark">Visi</h4>
                                <p class="text-gray-600 mt-1">Menjadi lembaga pendidikan anak usia dini terdepan yang
                                    menghasilkan generasi cerdas, kreatif, dan berkarakter.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div
                                    class="w-5 h-5 rounded-full bg-primary flex items-center justify-center text-white text-xs">
                                    ✓</div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-dark">Misi</h4>
                                <p class="text-gray-600 mt-1">Menyelenggarakan pendidikan berkualitas dengan pendekatan
                                    yang menyenangkan dan sesuai dengan tahap perkembangan anak.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div
                                    class="w-5 h-5 rounded-full bg-primary flex items-center justify-center text-white text-xs">
                                    ✓</div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-dark">Nilai</h4>
                                <p class="text-gray-600 mt-1">Integritas, kreativitas, kemandirian, dan kepedulian
                                    terhadap sesama dan lingkungan.</p>
                            </div>
                        </div>
                    </div>

                    <a href="#kontak"
                        class="inline-flex items-center px-6 py-3 bg-primary text-white font-medium rounded-xl hover:bg-primary/90 transition-colors">
                        Hubungi Kami
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>

                <div class="order-1 lg:order-2">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-4">
                            <div class="rounded-2xl overflow-hidden shadow-soft h-48">
                                <img src="https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                                    alt="Modern Classroom" class="w-full h-full object-cover">
                            </div>
                            <div class="rounded-2xl overflow-hidden shadow-soft h-64">
                                <img src="https://images.unsplash.com/photo-1544717305-996b815c338c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                                    alt="Children Learning" class="w-full h-full object-cover">
                            </div>
                        </div>
                        <div class="space-y-4 mt-8">
                            <div class="rounded-2xl overflow-hidden shadow-soft h-64">
                                <img src="https://images.unsplash.com/photo-1472162072942-cd5147eb3902?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                                    alt="Premium Playground" class="w-full h-full object-cover">
                            </div>
                            <div class="rounded-2xl overflow-hidden shadow-soft h-48">
                                <img src="https://images.unsplash.com/photo-1516627145497-ae6968895b74?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                                    alt="Premium Activities" class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    <section id="program" class="py-20 bg-dots">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h5 class="text-primary font-bold mb-3 tracking-wider">PROGRAM KAMI</h5>
                <h2 class="text-3xl md:text-4xl font-bold text-dark mb-4 font-display">Program Pendidikan</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">Kami menawarkan berbagai program pendidikan yang
                    dirancang untuk mengembangkan potensi anak secara optimal.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-3xl shadow-soft overflow-hidden group">
                    <div class="h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1526634332515-d56c5fd16991?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                            alt="Playgroup"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-6">
                        <div class="w-12 h-12 bg-yellow/20 rounded-xl flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-dark mb-2">Playgroup (2-3 tahun)</h3>
                        <p class="text-gray-600 mb-4">Program pengenalan awal untuk mengembangkan keterampilan sosial
                            dan motorik dasar anak.</p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-center text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-secondary mr-2"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Aktivitas bermain yang menyenangkan
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-secondary mr-2"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Pengembangan motorik halus
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-secondary mr-2"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Pengenalan lingkungan sosial
                            </li>
                        </ul>
                        <a href="#kontak"
                            class="inline-flex items-center text-primary font-medium hover:text-primary/80 transition-colors">
                            Selengkapnya
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-soft overflow-hidden group">
                    <div class="h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                            alt="TK A"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-6">
                        <div class="w-12 h-12 bg-primary/20 rounded-xl flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-dark mb-2">TK A (4-5 tahun)</h3>
                        <p class="text-gray-600 mb-4">Fokus pada pengembangan bahasa, kognitif, dan keterampilan
                            sosial-emosional anak.</p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-center text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-secondary mr-2"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Pengenalan huruf dan angka
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-secondary mr-2"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Aktivitas seni dan kreativitas
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-secondary mr-2"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Pengembangan keterampilan sosial
                            </li>
                        </ul>
                        <a href="#kontak"
                            class="inline-flex items-center text-primary font-medium hover:text-primary/80 transition-colors">
                            Selengkapnya
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-soft overflow-hidden group">
                    <div class="h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1484820540004-14229fe36ca4?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                            alt="TK B"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-6">
                        <div class="w-12 h-12 bg-secondary/20 rounded-xl flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-secondary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-dark mb-2">TK B (5-6 tahun)</h3>
                        <p class="text-gray-600 mb-4">Persiapan untuk pendidikan dasar dengan penekanan pada literasi
                            dan numerasi awal.</p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-center text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-secondary mr-2"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Pengenalan membaca dan menulis
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-secondary mr-2"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Konsep matematika dasar
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-secondary mr-2"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Persiapan masuk SD
                            </li>
                        </ul>
                        <a href="#kontak"
                            class="inline-flex items-center text-primary font-medium hover:text-primary/80 transition-colors">
                            Selengkapnya
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section (Kontak) -->
    <section id="kontak" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h5 class="text-primary font-bold mb-3 tracking-wider">HUBUNGI KAMI</h5>
                <h2 class="text-3xl md:text-4xl font-bold text-dark mb-4 font-display">Siap Untuk Bergabung?</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">Hubungi kami untuk informasi lebih lanjut atau
                    kunjungi sekolah kami untuk melihat langsung fasilitas yang kami tawarkan.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <div class="lg:col-span-5">
                    <div class="bg-white p-8 rounded-3xl shadow-soft h-full">
                        <h3 class="text-2xl font-bold text-dark mb-6 font-display">Informasi Kontak</h3>

                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div
                                    class="w-12 h-12 bg-yellow/20 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-dark text-lg">Alamat</h4>
                                    <p class="text-gray-600 mt-1">Jl. Raya Sari Kumara No. 123, Denpasar, Bali</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div
                                    class="w-12 h-12 bg-primary/20 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-dark text-lg">Telepon</h4>
                                    <p class="text-gray-600 mt-1">(0361) 123456</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div
                                    class="w-12 h-12 bg-secondary/20 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-secondary"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-dark text-lg">Email</h4>
                                    <p class="text-gray-600 mt-1">info@tksarikumara.ac.id</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div
                                    class="w-12 h-12 bg-accent/20 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-accent"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-dark text-lg">Jam Operasional</h4>
                                    <p class="text-gray-600 mt-1">Senin - Jumat: 07.30 - 14.00 WITA</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <h3 class="text-xl font-bold text-dark mb-4 font-display">Media Sosial</h3>
                            <div class="flex space-x-4">
                                <a href="#"
                                    class="h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                                    </svg>
                                </a>
                                <a href="#"
                                    class="h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                    </svg>
                                </a>
                                <a href="#"
                                    class="h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-7">
                    <div class="bg-white p-8 rounded-3xl shadow-soft">
                        <h3 class="text-2xl font-bold text-dark mb-6 font-display">Kirim Pesan</h3>

                        <form>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="name" class="block text-gray-700 font-medium mb-2">Nama
                                        Lengkap</label>
                                    <input type="text" id="name"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                        placeholder="Masukkan nama lengkap">
                                </div>

                                <div>
                                    <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                                    <input type="email" id="email"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                        placeholder="Masukkan alamat email">
                                </div>
                            </div>

                            <div class="mb-6">
                                <label for="phone" class="block text-gray-700 font-medium mb-2">Nomor
                                    Telepon</label>
                                <input type="tel" id="phone"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="Masukkan nomor telepon">
                            </div>

                            <div class="mb-6">
                                <label for="subject" class="block text-gray-700 font-medium mb-2">Subjek</label>
                                <select id="subject"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                    <option value="" disabled selected>Pilih subjek</option>
                                    <option value="info">Informasi Umum</option>
                                    <option value="admission">Pendaftaran</option>
                                    <option value="tour">Kunjungan Sekolah</option>
                                    <option value="other">Lainnya</option>
                                </select>
                            </div>

                            <div class="mb-6">
                                <label for="message" class="block text-gray-700 font-medium mb-2">Pesan</label>
                                <textarea id="message" rows="4"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="Tulis pesan Anda di sini"></textarea>
                            </div>

                            <button type="submit"
                                class="w-full px-6 py-4 bg-primary text-white font-medium rounded-xl hover:bg-primary/90 transition-all duration-300">Kirim
                                Pesan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Login Section (Masuk) -->
    <section id="masuk" class="py-20 bg-dots">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h5 class="text-primary font-bold mb-3 tracking-wider">AREA ANGGOTA</h5>
                <h2 class="text-3xl md:text-4xl font-bold text-dark mb-4 font-display">Portal Orang Tua</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">Akses informasi perkembangan anak, jadwal kegiatan,
                    dan komunikasi dengan guru melalui portal orang tua kami.</p>
            </div>

            <div class="max-w-md mx-auto bg-white p-8 rounded-3xl shadow-soft relative">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-primary/5 rounded-full"></div>
                <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-secondary/5 rounded-full"></div>

                <form class="relative z-10">
                    <div class="mb-6">
                        <label for="login-email" class="block text-gray-700 font-medium mb-2">Email</label>
                        <input type="email" id="login-email"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="Masukkan alamat email">
                    </div>

                    <div class="mb-6">
                        <label for="login-password" class="block text-gray-700 font-medium mb-2">Password</label>
                        <input type="password" id="login-password"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="Masukkan password">
                    </div>

                    <button type="submit"
                        class="w-full px-6 py-4 bg-primary text-white font-medium rounded-xl hover:bg-primary/90 transition-all duration-300 mb-4">Masuk</button>

                    <div class="text-center">
                        <a href="#" class="text-primary hover:text-primary/80 transition-colors">Lupa
                            Password?</a>
                        <p class="mt-4 text-gray-600">Belum memiliki akun? <a href="#"
                                class="text-primary hover:text-primary/80 transition-colors">Hubungi Admin</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="md:col-span-2">
                    <div class="flex items-center mb-6">
                        <div
                            class="h-12 w-12 rounded-lg bg-primary flex items-center justify-center text-white font-bold text-xl mr-3">
                            SK</div>
                        <span class="text-white font-bold text-xl tracking-tight font-display">TK Sari Kumara</span>
                    </div>
                    <p class="text-gray-400 mb-6 leading-relaxed">TK Sari Kumara adalah lembaga pendidikan anak usia
                        dini premium yang berkomitmen untuk memberikan pendidikan berkualitas tinggi dengan pendekatan
                        holistik dan fasilitas modern.</p>
                    <div class="flex space-x-4">
                        <a href="#"
                            class="h-10 w-10 rounded-full bg-white/10 flex items-center justify-center text-white hover:bg-primary transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="h-10 w-10 rounded-full bg-white/10 flex items-center justify-center text-white hover:bg-primary transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="h-10 w-10 rounded-full bg-white/10 flex items-center justify-center text-white hover:bg-primary transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-6 font-display">Link Cepat</h3>
                    <ul class="space-y-3">
                        <li><a href="#beranda" class="text-gray-400 hover:text-primary transition-colors">Beranda</a>
                        </li>
                        <li><a href="#tentang" class="text-gray-400 hover:text-primary transition-colors">Tentang
                                Kami</a></li>
                        <li><a href="#program" class="text-gray-400 hover:text-primary transition-colors">Program</a>
                        </li>
                        <li><a href="#kontak" class="text-gray-400 hover:text-primary transition-colors">Hubungi
                                Kami</a></li>
                        <li><a href="#masuk" class="text-gray-400 hover:text-primary transition-colors">Portal Orang
                                Tua</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-6 font-display">Kontak</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-primary mr-3 flex-shrink-0 mt-0.5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-gray-400">Jl. Raya Sari Kumara No. 123, Denpasar, Bali</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-primary mr-3 flex-shrink-0 mt-0.5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span class="text-gray-400">(0361) 123456</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-primary mr-3 flex-shrink-0 mt-0.5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="text-gray-400">info@tksarikumara.ac.id</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-12 pt-8 text-center">
                <p class="text-gray-400">&copy; 2025 TK Sari Kumara. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript for Mobile Menu Toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });

            // Close mobile menu when clicking on a link
            const mobileMenuLinks = mobileMenu.querySelectorAll('a');
            mobileMenuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenu.classList.add('hidden');
                });
            });
        });
    </script>
</body>

</html>
