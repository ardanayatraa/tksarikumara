<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - TK Sari Kumara</title>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&family=Fredoka+One&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#10B981', // Emerald-500 - Light green primary
                        secondary: '#34D399', // Emerald-400 - Lighter green
                        accent: '#059669', // Emerald-600 - Darker green accent
                        yellow: '#FCD34D', // Amber-300
                        teal: '#14B8A6', // Teal-500
                        orange: '#F59E0B', // Amber-500
                        dark: '#064E3B', // Emerald-900 - Dark green instead of blue
                        'dark-green': '#065F46', // Emerald-800
                        'light-green': '#D1FAE5', // Emerald-100
                        'soft-green': '#A7F3D0', // Emerald-200
                    },
                    fontFamily: {
                        sans: ['Nunito', 'sans-serif'],
                        display: ['Fredoka One', 'cursive'],
                    },
                    boxShadow: {
                        'soft': '0 10px 25px -5px rgba(16, 185, 129, 0.1)',
                        'hover': '0 20px 25px -5px rgba(16, 185, 129, 0.15), 0 10px 10px -5px rgba(16, 185, 129, 0.08)',
                    }
                }
            }
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    <!-- Adds the Core Table Styles -->
    @rappasoftTableStyles
    <!-- Tambahkan di dalam <head> pada layout utama -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


    <!-- Adds any relevant Third-Party Styles (Used for DateRangeFilter (Flatpickr) and NumberRangeFilter) -->
    @rappasoftTableThirdPartyStyles
</head>

<body class="font-sans bg-light-green/30 flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-dark text-white hidden md:flex flex-col shadow-xl">
        <div class="p-4 border-b border-emerald-700">
            <div class="flex items-center space-x-3">
                <div
                    class="h-10 w-10 rounded-lg bg-primary flex items-center justify-center text-white font-bold text-xl shadow-lg">
                    SK</div>
                <span class="text-white font-bold text-xl tracking-tight font-display">Sari Kumara</span>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto py-4">
            <div class="px-4 mb-2 text-xs font-semibold text-emerald-300 uppercase tracking-wider">
                Menu Utama
            </div>
            @php
                $role = session('role');
            @endphp

            @if ($role === 'admin')
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-3 text-white {{ Request::is('admin/dashboard') ? 'bg-primary/30 border-r-4 border-primary shadow-lg' : 'hover:bg-primary/20' }} transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.data-account') }}"
                    class="flex items-center px-4 py-3 text-emerald-100 hover:bg-primary/20 hover:text-white transition-all duration-200 {{ Request::is('admin/data-akun') ? 'bg-primary/30 border-r-4 border-primary shadow-lg' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Data Akun
                </a>
                <a href="{{ route('admin.master-data') }}"
                    class="flex items-center px-4 py-3 text-emerald-100 hover:bg-primary/20 hover:text-white transition-all duration-200 {{ Request::is('admin/master-data') ? 'bg-primary/30 border-r-4 border-primary shadow-lg' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7h18M3 12h18M3 17h18" />
                    </svg>
                    <span>Master Data</span>
                </a>

                <a href="{{ route('profil.admin') }}"
                    class="flex items-center px-4 py-3 text-white {{ Request::is('profil-admin') ? 'bg-primary/30 border-r-4 border-primary shadow-lg' : 'hover:bg-primary/20' }} transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    Profil
                </a>
            @elseif($role === 'guru')
                <a href="{{ route('guru.dashboard') }}"
                    class="flex items-center px-4 py-3 text-white {{ Request::is('guru/dashboard') ? 'bg-primary/30 border-r-4 border-primary shadow-lg' : 'hover:bg-primary/20' }} transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('guru.aspek-penilaian') }}"
                    class="flex items-center px-4 py-3 text-emerald-100 hover:bg-primary/20 hover:text-white transition-all duration-200 {{ Request::is('guru/aspek-penilaian') ? 'bg-primary/30 border-r-4 border-primary shadow-lg' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-6h13v6m-13 0H4a1 1 0 01-1-1v-4a1 1 0 011-1h5m0 6v2m0-2v-2" />
                    </svg>
                    Aspek Penilaian
                </a>

                <a href="{{ route('guru.penilaian') }}"
                    class="flex items-center px-4 py-3 text-emerald-100 hover:bg-primary/20 hover:text-white transition-all duration-200 {{ Request::is('guru/penilaian') ? 'bg-primary/30 border-r-4 border-primary shadow-lg' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m-6-8h6m2-2v12a2 2 0 002 2H5a2 2 0 01-2-2V6a2 2 0 012-2h16a2 2 0 012 2z" />
                    </svg>
                    Penilaian
                </a>

                <a href="{{ route('profil.guru') }}"
                    class="flex items-center px-4 py-3 text-white {{ Request::is('profil-guru') ? 'bg-primary/30 border-r-4 border-primary shadow-lg' : 'hover:bg-primary/20' }} transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    Profil
                </a>
            @elseif($role === 'siswa')
                <a href="{{ route('dashboard.siswa') }}"
                    class="flex items-center px-4 py-3 text-white {{ Request::is('dashboard') ? 'bg-primary/30 border-r-4 border-primary shadow-lg' : 'hover:bg-primary/20' }} transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('profil.siswa') }}"
                    class="flex items-center px-4 py-3 text-white {{ Request::is('profil-siswa') ? 'bg-primary/30 border-r-4 border-primary shadow-lg' : 'hover:bg-primary/20' }} transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    Profil
                </a>
            @elseif($role === 'kepsek')
                <a href="{{ route('dashboard.kepsek') }}"
                    class="flex items-center px-4 py-3 text-white {{ Request::is('kepsek/dashboard') ? 'bg-primary/30 border-r-4 border-primary shadow-lg' : 'hover:bg-primary/20' }} transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('penilaian.kepsek') }}"
                    class="flex items-center px-4 py-3 text-emerald-100 hover:bg-primary/20 hover:text-white transition-all duration-200 {{ Request::is('kepsek/penilaian') ? 'bg-primary/30 border-r-4 border-primary shadow-lg' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m-6-8h6m2-2v12a2 2 0 002 2H5a2 2 0 01-2-2V6a2 2 0 012-2h16a2 2 0 012 2z" />
                    </svg>
                    Penilaian
                </a>
                <a href="{{ route('profil.kepala-sekolah') }}"
                    class="flex items-center px-4 py-3 text-white {{ Request::is('kepsek/profil-kepala/sekolah') ? 'bg-primary/30 border-r-4 border-primary shadow-lg' : 'hover:bg-primary/20' }} transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    Profil
                </a>
            @else
                <div class="font-medium text-sm text-emerald-200 px-4">User tidak ditemukan</div>
            @endif

        </nav>

        <div class="p-4 border-t border-emerald-700">
            <a href="#"
                class="flex items-center text-emerald-200 hover:text-white hover:bg-primary/20 p-2 rounded-lg transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Keluar
            </a>
        </div>
    </aside>

    <!-- Mobile sidebar backdrop -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-black/50 z-20 md:hidden hidden"></div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Navigation -->
        <header class="bg-white shadow-lg border-b-2 border-primary/20 z-10">
            <div class="flex items-center justify-between h-16 px-4">
                <div class="flex items-center">
                    <button id="mobile-menu-button"
                        class="text-emerald-600 hover:text-emerald-800 md:hidden focus:outline-none p-2 rounded-lg hover:bg-light-green transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="ml-4 md:hidden flex items-center">
                        <div
                            class="h-8 w-8 rounded-lg bg-primary flex items-center justify-center text-white font-bold text-sm shadow-lg">
                            SK</div>
                        <span class="text-dark font-bold text-lg ml-2 tracking-tight font-display">Sari Kumara</span>
                    </div>
                    <div class="hidden md:block ml-4">
                        <div class="relative">
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button
                            class="flex items-center focus:outline-none hover:bg-light-green p-2 rounded-lg transition-colors"
                            id="user-menu-button">
                            <div class="h-8 w-8 rounded-full bg-soft-green flex items-center justify-center shadow-md">
                                <svg class="h-5 w-5 text-emerald-700" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z" />
                                </svg>
                            </div>

                            @if ($role === 'siswa')
                                <span
                                    class="ml-2 text-sm font-medium text-emerald-800 hidden md:block">{{ Auth::guard('siswa')->user()->namaSiswa }}</span>
                            @elseif($role === 'guru')
                                <span
                                    class="ml-2 text-sm font-medium text-emerald-800 hidden md:block">{{ Auth::guard('guru')->user()->namaGuru }}</span>
                            @elseif($role === 'kepsek')
                                <span
                                    class="ml-2 text-sm font-medium text-emerald-800 hidden md:block">{{ Auth::guard('kepsek')->user()->namaKepalaSekolah }}</span>
                            @else
                                <span
                                    class="ml-2 text-sm font-medium text-emerald-800 hidden md:block">{{ Auth::guard('admin')->user()->email }}</span>
                            @endif

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-emerald-600 ml-1 hidden md:block" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-emerald-200 py-1 hidden"
                            id="user-menu">
                            <div class="border-t border-emerald-100"></div>
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();"
                                    class="block px-4 py-2 text-sm text-emerald-700 hover:bg-light-green transition-colors">
                                    {{ __('Log Out') }}
                                </x-responsive-nav-link>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto bg-gradient-to-br from-light-green/20 to-soft-green/10 p-4">
            <div class="">
                {{ $slot }}
            </div>
        </main>
    </div>

    <!-- Mobile Sidebar -->
    <div id="mobile-sidebar"
        class="fixed inset-y-0 left-0 w-64 bg-dark text-white z-30 transform -translate-x-full transition-transform duration-300 ease-in-out md:hidden shadow-2xl">
        <div class="p-4 border-b border-emerald-700">
            <div class="flex items-center space-x-3">
                <div
                    class="h-10 w-10 rounded-lg bg-primary flex items-center justify-center text-white font-bold text-xl shadow-lg">
                    SK</div>
                <span class="text-white font-bold text-xl tracking-tight font-display">Sari Kumara</span>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto py-4">
            <div class="px-4 mb-2 text-xs font-semibold text-emerald-300 uppercase tracking-wider">
                Menu Utama
            </div>

            @if ($role === 'admin')
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-3 text-white {{ Request::is('admin/dashboard') ? 'bg-primary/30 border-r-4 border-primary' : 'hover:bg-primary/20' }} transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.data-account') }}"
                    class="flex items-center px-4 py-3 text-emerald-100 hover:bg-primary/20 hover:text-white transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Data Akun
                </a>
                <a href="{{ route('admin.master-data') }}"
                    class="flex items-center px-4 py-3 text-emerald-100 hover:bg-primary/20 hover:text-white transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7h18M3 12h18M3 17h18" />
                    </svg>
                    <span>Master Data</span>
                </a>
            @elseif($role === 'guru')
                <a href="{{ route('guru.dashboard') }}"
                    class="flex items-center px-4 py-3 text-white {{ Request::is('guru/dashboard') ? 'bg-primary/30 border-r-4 border-primary' : 'hover:bg-primary/20' }} transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('guru.aspek-penilaian') }}"
                    class="flex items-center px-4 py-3 text-emerald-100 hover:bg-primary/20 hover:text-white transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-6h13v6m-13 0H4a1 1 0 01-1-1v-4a1 1 0 011-1h5m0 6v2m0-2v-2" />
                    </svg>
                    Aspek Penilaian
                </a>
                <a href="{{ route('guru.penilaian') }}"
                    class="flex items-center px-4 py-3 text-emerald-100 hover:bg-primary/20 hover:text-white transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m-6-8h6m2-2v12a2 2 0 002 2H5a2 2 0 01-2-2V6a2 2 0 012-2h16a2 2 0 012 2z" />
                    </svg>
                    Penilaian
                </a>
            @endif
        </nav>

        <div class="p-4 border-t border-emerald-700">
            <a href="#"
                class="flex items-center text-emerald-200 hover:text-white hover:bg-primary/20 p-2 rounded-lg transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Keluar
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileSidebar = document.getElementById('mobile-sidebar');
            const sidebarBackdrop = document.getElementById('sidebar-backdrop');

            mobileMenuButton.addEventListener('click', function() {
                mobileSidebar.classList.toggle('-translate-x-full');
                sidebarBackdrop.classList.toggle('hidden');
            });

            sidebarBackdrop.addEventListener('click', function() {
                mobileSidebar.classList.add('-translate-x-full');
                sidebarBackdrop.classList.add('hidden');
            });

            // User menu dropdown
            const userMenuButton = document.getElementById('user-menu-button');
            const userMenu = document.getElementById('user-menu');

            userMenuButton.addEventListener('click', function() {
                userMenu.classList.toggle('hidden');
            });

            // Close user menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                    userMenu.classList.add('hidden');
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    @stack('scripts')
    <!-- Adds the Core Table Scripts -->
    @rappasoftTableScripts
    @stack('modals')

    @livewireScripts
    <!-- Adds any relevant Third-Party Scripts (e.g. Flatpickr) -->
    @rappasoftTableThirdPartyScripts
</body>

</html>
