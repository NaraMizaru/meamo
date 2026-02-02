<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Meamo Photo Booth - Layanan photo booth profesional untuk berbagai acara">
    <title>@yield('title', 'Beranda') - Meamo Photo Booth</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .nav-link {
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #22C55E, #D97706);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        .mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .mobile-menu.open {
            max-height: 500px;
        }

        .hamburger span {
            transition: all 0.3s ease;
        }

        .hamburger.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -6px);
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">

    <!-- Navigation -->
    <nav class="bg-white/95 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 lg:h-18">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-2 flex-shrink-0">
                    <div
                        class="w-9 h-9 sm:w-10 sm:h-10 bg-gradient-to-br from-gray-900 via-green-700 to-amber-500 rounded-xl flex items-center justify-center shadow-md">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <span
                        class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-gray-900 to-green-700 bg-clip-text text-transparent">Meamo</span>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-1">
                    <a href="{{ route('home') }}"
                        class="nav-link px-4 py-2 text-gray-700 hover:text-green-600 font-medium transition-colors rounded-lg hover:bg-green-50 {{ request()->routeIs('home') ? 'text-green-600 active bg-green-50' : '' }}">Beranda</a>
                    <!-- <a href="{{ route('templates') }}"
                        class="nav-link px-4 py-2 text-gray-700 hover:text-green-600 font-medium transition-colors rounded-lg hover:bg-green-50 {{ request()->routeIs('templates') ? 'text-green-600 active bg-green-50' : '' }}">Template</a> -->
                    <a href="{{ route('services') }}"
                        class="nav-link px-4 py-2 text-gray-700 hover:text-green-600 font-medium transition-colors rounded-lg hover:bg-green-50 {{ request()->routeIs('services') ? 'text-green-600 active bg-green-50' : '' }}">Layanan</a>
                    <a href="{{ route('schedules') }}"
                        class="nav-link px-4 py-2 text-gray-700 hover:text-green-600 font-medium transition-colors rounded-lg hover:bg-green-50 {{ request()->routeIs('schedules') ? 'text-green-600 active bg-green-50' : '' }}">Jadwal</a>
                    <a href="{{ route('contact') }}"
                        class="nav-link px-4 py-2 text-gray-700 hover:text-green-600 font-medium transition-colors rounded-lg hover:bg-green-50 {{ request()->routeIs('contact') ? 'text-green-600 active bg-green-50' : '' }}">Kontak</a>
                </div>

                <!-- Desktop Auth Buttons -->
                <div class="hidden lg:flex items-center space-x-3">
                    @auth
                        <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}"
                            class="px-4 py-2 text-gray-700 hover:text-green-600 font-medium transition-colors">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 text-gray-700 hover:text-red-600 font-medium transition-colors">Keluar</button>
                        </form>
                        @if(!Auth::user()->isAdmin())
                            <a href="{{ route('booking.create') }}"
                                class="bg-gradient-to-r from-green-600 to-amber-500 hover:from-green-500 hover:to-amber-400 text-white px-5 py-2.5 rounded-xl font-semibold shadow-md hover:shadow-lg transition-all duration-300">
                                Pesan Sekarang
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 text-gray-700 hover:text-green-600 font-medium transition-colors">Masuk</a>
                        <a href="{{ route('register') }}"
                            class="bg-gradient-to-r from-green-600 to-amber-500 hover:from-green-500 hover:to-amber-400 text-white px-5 py-2.5 rounded-xl font-semibold shadow-md hover:shadow-lg transition-all duration-300">
                            Daftar
                        </a>
                    @endauth
                </div>

                <!-- Mobile Right Side -->
                <div class="flex lg:hidden items-center space-x-2">
                    @guest
                        <a href="{{ route('login') }}"
                            class="text-sm font-medium text-gray-700 hover:text-green-600 px-2 py-1">Masuk</a>
                    @endguest

                    <!-- Mobile Hamburger -->
                    <button
                        class="hamburger flex flex-col justify-center items-center w-10 h-10 rounded-lg hover:bg-gray-100 transition-colors"
                        onclick="toggleMobileMenu()">
                        <span class="block w-5 h-0.5 bg-gray-900 mb-1"></span>
                        <span class="block w-5 h-0.5 bg-gray-900 mb-1"></span>
                        <span class="block w-5 h-0.5 bg-gray-900"></span>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="mobile-menu lg:hidden" id="mobileMenu">
                <div class="py-4 space-y-1 border-t border-gray-100">
                    <a href="{{ route('home') }}"
                        class="block px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-xl transition-colors font-medium {{ request()->routeIs('home') ? 'bg-green-50 text-green-600' : '' }}">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Beranda
                        </span>
                    </a>
                    <!-- <a href="{{ route('templates') }}"
                        class="block px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-xl transition-colors font-medium {{ request()->routeIs('templates') ? 'bg-green-50 text-green-600' : '' }}">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Template
                        </span>
                    </a> -->
                    <a href="{{ route('services') }}"
                        class="block px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-xl transition-colors font-medium {{ request()->routeIs('services') ? 'bg-green-50 text-green-600' : '' }}">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            Layanan
                        </span>
                    </a>
                    <a href="{{ route('schedules') }}"
                        class="block px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-xl transition-colors font-medium {{ request()->routeIs('schedules') ? 'bg-green-50 text-green-600' : '' }}">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Jadwal
                        </span>
                    </a>
                    <a href="{{ route('contact') }}"
                        class="block px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-xl transition-colors font-medium {{ request()->routeIs('contact') ? 'bg-green-50 text-green-600' : '' }}">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Kontak
                        </span>
                    </a>

                    <div class="border-t border-gray-100 pt-4 mt-4 px-4 space-y-3">
                        @auth
                            <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}"
                                class="block py-2.5 text-gray-700 hover:text-green-600 font-medium transition-colors">Dashboard</a>
                            @if(!Auth::user()->isAdmin())
                                <a href="{{ route('booking.create') }}"
                                    class="block w-full text-center bg-gradient-to-r from-green-600 to-amber-500 text-white py-3 rounded-xl font-semibold shadow-md">
                                    Pesan Sekarang
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left py-2.5 text-red-600 hover:text-red-700 font-medium transition-colors">Keluar</button>
                            </form>
                        @else
                            <a href="{{ route('register') }}"
                                class="block w-full text-center bg-gradient-to-r from-green-600 to-amber-500 text-white py-3 rounded-xl font-semibold shadow-md">
                                Daftar Sekarang
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-gray-900 via-gray-900 to-gray-800 text-white mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="lg:col-span-1">
                    <div class="flex items-center space-x-2 mb-4">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-green-500 to-amber-500 rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <span class="text-2xl font-bold">Meamo</span>
                    </div>
                    <p class="text-gray-400 mb-6 text-sm leading-relaxed">
                        Abadikan momen berharga Anda dengan layanan photo booth profesional kami. Kualitas terbaik untuk
                        setiap momen.
                    </p>
                    <!-- Social Links -->
                    <div class="flex space-x-3">
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 hover:bg-gradient-to-br hover:from-green-500 hover:to-amber-500 rounded-xl flex items-center justify-center transition-all duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 hover:bg-gradient-to-br hover:from-green-500 hover:to-amber-500 rounded-xl flex items-center justify-center transition-all duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 hover:bg-gradient-to-br hover:from-green-500 hover:to-amber-500 rounded-xl flex items-center justify-center transition-all duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-semibold text-lg mb-4 text-amber-400">Tautan Cepat</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('home') }}"
                                class="text-gray-400 hover:text-green-400 transition-colors text-sm">Beranda</a></li>
                        <!-- <li><a href="{{ route('templates') }}"
                                class="text-gray-400 hover:text-green-400 transition-colors text-sm">Template</a></li> -->
                        <li><a href="{{ route('services') }}"
                                class="text-gray-400 hover:text-green-400 transition-colors text-sm">Layanan</a></li>
                        <li><a href="{{ route('schedules') }}"
                                class="text-gray-400 hover:text-green-400 transition-colors text-sm">Jadwal</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div>
                    <h4 class="font-semibold text-lg mb-4 text-amber-400">Layanan Kami</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('services') }}"
                                class="text-gray-400 hover:text-green-400 transition-colors text-sm">Photo Booth</a>
                        </li>
                        <li><a href="{{ route('services') }}"
                                class="text-gray-400 hover:text-green-400 transition-colors text-sm">Video Booth</a>
                        </li>
                        <li><a href="{{ route('services') }}"
                                class="text-gray-400 hover:text-green-400 transition-colors text-sm">Custom Template</a>
                        </li>
                        <li><a href="{{ route('booking.create') }}"
                                class="text-gray-400 hover:text-green-400 transition-colors text-sm">Pesan Sekarang</a>
                        </li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="font-semibold text-lg mb-4 text-amber-400">Hubungi Kami</h4>
                    <ul class="space-y-3">
                        <li class="flex items-center text-gray-400 text-sm">
                            <svg class="w-4 h-4 mr-3 text-green-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            info@meamo.com
                        </li>
                        <li class="flex items-center text-gray-400 text-sm">
                            <svg class="w-4 h-4 mr-3 text-green-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            +62 831-7304-3030
                        </li>
                        <li class="flex items-start text-gray-400 text-sm">
                            <svg class="w-4 h-4 mr-3 mt-0.5 text-green-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Lobby SMKN 2 Sukabumi<br>Sukabumi, Jawa Barat, Indonesia 43141</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-10 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} Meamo Photo Booth. Seluruh hak cipta dilindungi.
                </p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-gray-500 hover:text-green-400 text-sm transition-colors">Syarat &
                        Ketentuan</a>
                    <a href="#" class="text-gray-500 hover:text-green-400 text-sm transition-colors">Kebijakan
                        Privasi</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/6283173043030" target="_blank"
        class="fixed bottom-6 right-6 w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 hover:from-green-400 hover:to-green-500 text-white rounded-full shadow-lg shadow-green-500/30 flex items-center justify-center transition-all duration-300 hover:scale-110 z-50">
        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
            <path
                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
        </svg>
    </a>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const hamburger = document.querySelector('.hamburger');
            menu.classList.toggle('open');
            hamburger.classList.toggle('active');
        }
    </script>

</body>

</html>