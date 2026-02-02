<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Meamo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Mobile Sidebar Transitions */
        .sidebar-overlay {
            transition: opacity 0.3s ease-in-out;
        }

        .sidebar-panel {
            transition: transform 0.3s ease-in-out;
        }

        .sidebar-closed {
            transform: translateX(-100%);
        }

        @media (min-width: 768px) {
            .sidebar-closed {
                transform: translateX(0);
            }
        }

        .sidebar-open {
            transform: translateX(0);
        }

        /* Active nav item */
        .nav-active {
            position: relative;
        }

        .nav-active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(to bottom, #3b82f6, #8b5cf6);
            border-radius: 0 4px 4px 0;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-slate-100 to-gray-100 min-h-screen">
    <div class="min-h-screen flex">

        <!-- Mobile Sidebar Overlay -->
        <div id="sidebarOverlay" class="sidebar-overlay fixed inset-0 bg-black/50 z-40 md:hidden hidden"
            onclick="closeSidebar()"></div>

        <!-- Sidebar -->
        <aside id="sidebarPanel"
            class="sidebar-panel sidebar-closed md:translate-x-0 fixed md:sticky top-0 left-0 h-screen w-72 bg-gradient-to-b from-gray-900 to-slate-900 text-white z-50 flex flex-col shadow-2xl">
            <!-- Logo Section -->
            <div class="p-5 border-b border-gray-700/50">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <span class="text-xl font-bold text-white">Meamo</span>
                        <span
                            class="ml-2 text-xs bg-purple-600/50 text-purple-200 px-2 py-0.5 rounded-full font-medium">Admin</span>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 py-4 px-3 space-y-1 overflow-y-auto">
                <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Menu Utama</p>

                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'nav-active bg-white/10 text-white font-semibold' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    Dashboard
                </a>

                @if(Auth::user()->isAdminWeb())
                    <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mt-6 mb-2">Konten & Akun</p>
                    <a href="{{ route('admin.galleries.index') }}"
                        class="flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.galleries.*') ? 'nav-active bg-white/10 text-white font-semibold' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Galeri
                    </a>
                    <a href="{{ route('admin.templates.index') }}"
                        class="flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.templates.*') ? 'nav-active bg-white/10 text-white font-semibold' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Template
                    </a>
                    <a href="{{ route('admin.accounts.index') }}"
                        class="flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.accounts.*') ? 'nav-active bg-white/10 text-white font-semibold' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        Kelola Akun
                    </a>
                @endif

                @if(Auth::user()->isAdmin())


                    <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mt-6 mb-2">Pemesanan</p>

                    <a href="{{ route('admin.bookings.index') }}"
                        class="flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.bookings.index') ? 'nav-active bg-white/10 text-white font-semibold' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        Pemesanan
                    </a>

                    <a href="{{ route('admin.bookings.history') }}"
                        class="flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.bookings.history') ? 'nav-active bg-white/10 text-white font-semibold' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Riwayat Pesanan
                    </a>

                    <a href="{{ route('admin.schedules.index') }}"
                        class="flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.schedules.*') ? 'nav-active bg-white/10 text-white font-semibold' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Jadwal
                    </a>


                    @if(Auth::user()->isAdmin())
                        <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mt-6 mb-2">Keuangan</p>
                        <a href="{{ route('admin.finance.index') }}"
                            class="flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.finance.index') ? 'nav-active bg-white/10 text-white font-semibold' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                            Transaksi
                        </a>
                        <a href="{{ route('admin.finance.analysis') }}"
                            class="flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.finance.analysis') ? 'nav-active bg-white/10 text-white font-semibold' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                            </svg>
                            Analisis
                        </a>
                        <a href="{{ route('admin.finance.history') }}"
                            class="flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.finance.history') ? 'nav-active bg-white/10 text-white font-semibold' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Riwayat
                        </a>
                    @endif

                    <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mt-6 mb-2">Katalog</p>

                    <a href="{{ route('admin.services.index') }}"
                        class="flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.services.*') ? 'nav-active bg-white/10 text-white font-semibold' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                        Layanan
                    </a>

                    <a href="{{ route('admin.items.index') }}"
                        class="flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.items.*') ? 'nav-active bg-white/10 text-white font-semibold' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Item
                    </a>

                    <a href="{{ route('admin.service-addons.index') }}"
                        class="flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.service-addons.*') ? 'nav-active bg-white/10 text-white font-semibold' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Addons
                    </a>

                    <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mt-6 mb-2">Lainnya</p>

                    <a href="{{ route('admin.promos.index') }}"
                        class="flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.promos.*') ? 'nav-active bg-white/10 text-white font-semibold' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                            </path>
                        </svg>
                        Promo
                    </a>

                    <a href="{{ route('admin.settings.index') }}"
                        class="flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.settings.*') ? 'nav-active bg-white/10 text-white font-semibold' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Pengaturan
                    </a>
                @endif
            </nav>

            <!-- Admin Info & Logout -->
            <div class="p-4 border-t border-gray-700/50 bg-gray-900/50">
                <div class="flex items-center gap-3 mb-3 px-2">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400 truncate">Administrator</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center w-full px-3 py-2.5 rounded-xl text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Header -->
            <header class="bg-white/80 backdrop-blur-sm shadow-sm sticky top-0 z-30 border-b border-gray-200/50">
                <div class="px-4 md:px-6 py-4 flex justify-between items-center">
                    <!-- Mobile Menu Button -->
                    <button onclick="openSidebar()"
                        class="md:hidden p-2 -ml-2 rounded-lg hover:bg-gray-100 transition-colors">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>

                    <h2 class="text-lg md:text-xl font-bold text-gray-800">@yield('header')</h2>

                    <div class="hidden md:flex items-center gap-3">
                        <span class="text-sm text-gray-500">Halo,</span>
                        <span class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</span>
                    </div>

                    <!-- Mobile Admin Badge -->
                    <div
                        class="md:hidden w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            <!-- Main -->
            <main class="flex-1 p-4 md:p-6 overflow-y-auto">
                @if(session('success'))
                    <div
                        class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4 flex items-center gap-3 shadow-sm">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div
                        class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 flex items-center gap-3 shadow-sm">
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function openSidebar() {
            document.getElementById('sidebarOverlay').classList.remove('hidden');
            document.getElementById('sidebarPanel').classList.remove('sidebar-closed');
            document.getElementById('sidebarPanel').classList.add('sidebar-open');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            document.getElementById('sidebarOverlay').classList.add('hidden');
            document.getElementById('sidebarPanel').classList.remove('sidebar-open');
            document.getElementById('sidebarPanel').classList.add('sidebar-closed');
            document.body.style.overflow = '';
        }

        // Close sidebar on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeSidebar();
        });

        // Close sidebar when clicking a link (mobile)
        document.querySelectorAll('#sidebarPanel a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 768) closeSidebar();
            });
        });
    </script>
</body>

</html>