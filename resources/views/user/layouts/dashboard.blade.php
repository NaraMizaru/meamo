<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Meamo</title>
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

        /* Active nav item left border */
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
            background: linear-gradient(to bottom, #3b82f6, #6366f1);
            border-radius: 0 4px 4px 0;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen">
    <div class="min-h-screen flex">

        <!-- Mobile Sidebar Overlay -->
        <div id="sidebarOverlay" class="sidebar-overlay fixed inset-0 bg-black/50 z-40 md:hidden hidden"
            onclick="closeSidebar()"></div>

        <!-- Sidebar -->
        <aside id="sidebarPanel"
            class="sidebar-panel sidebar-closed md:translate-x-0 fixed md:sticky top-0 left-0 h-screen w-72 bg-white shadow-xl z-50 flex flex-col">
            <!-- Logo Section -->
            <div class="p-5 border-b border-gray-100 bg-gradient-to-r from-blue-600 to-indigo-600">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold text-white">Meamo</span>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 py-6 px-4 space-y-2 overflow-y-auto">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'nav-active bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-600 font-semibold shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('booking.create') }}"
                    class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('booking.create') ? 'nav-active bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-600 font-semibold shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                        </path>
                    </svg>
                    Pesan Sekarang
                </a>

                <a href="{{ route('bookings.index') }}"
                    class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('bookings.index') ? 'nav-active bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-600 font-semibold shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                        </path>
                    </svg>
                    Daftar Booking
                </a>

                <a href="{{ route('bookings.history') }}"
                    class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('bookings.history') ? 'nav-active bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-600 font-semibold shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                    Riwayat Pesanan
                </a>

                <a href="{{ route('profile.edit') }}"
                    class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('profile.edit') ? 'nav-active bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-600 font-semibold shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Profil
                </a>
            </nav>

            <!-- User Info & Logout -->
            <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                <div class="flex items-center gap-3 mb-4 px-2">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center w-full px-4 py-2.5 rounded-xl text-red-600 hover:bg-red-50 transition-colors">
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
            <header class="bg-white/80 backdrop-blur-sm shadow-sm sticky top-0 z-30 border-b border-gray-100">
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
                        <span class="text-sm text-gray-500">Selamat datang,</span>
                        <span class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</span>
                    </div>

                    <!-- Mobile User Initial -->
                    <div
                        class="md:hidden w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
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

                @if(session('status'))
                    <div
                        class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-xl mb-4 flex items-center gap-3 shadow-sm">
                        <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ session('status') }}</span>
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