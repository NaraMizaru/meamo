<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Meamo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white relative">
            <div class="p-4">
                <h1 class="text-2xl font-bold">Meamo Admin</h1>
            </div>

            <nav class="mt-4">
                <a href="{{ route('admin.dashboard') }}"
                    class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                    Dashboard
                </a>

                <a href="{{ route('admin.bookings.index') }}"
                    class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.bookings.*') ? 'bg-gray-700' : '' }}">
                    Bookings
                </a>

                <a href="{{ route('admin.services.index') }}"
                    class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.services.*') ? 'bg-gray-700' : '' }}">
                    Services
                </a>

                <a href="{{ route('admin.schedules.index') }}"
                    class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.schedules.*') ? 'bg-gray-700' : '' }}">
                    Schedules
                </a>

                <a href="{{ route('admin.galleries.index') }}"
                    class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.galleries.*') ? 'bg-gray-700' : '' }}">
                    Gallery
                </a>
                <a href="{{ route('admin.items.index') }}"
                    class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.items.*') ? 'bg-gray-700' : '' }}">
                    Items
                </a>

                <a href="{{ route('admin.service-addons.index') }}"
                    class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.service-addons.*') ? 'bg-gray-700' : '' }}">
                    Addons
                </a>

                <a href="{{ route('admin.promos.index') }}"
                    class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.promos.*') ? 'bg-gray-700' : '' }}">
                    Promos
                </a>

                <a href="{{ route('admin.settings.index') }}"
                    class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.settings.*') ? 'bg-gray-700' : '' }}">
                    Settings
                </a>

                <a href="{{ route('admin.templates.index') }}"
                    class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.galleries.*') ? 'bg-gray-700' : '' }}">
                    Templates
                </a>
            </nav>

            <div class="absolute bottom-0 w-full p-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1">
            <header class="bg-white shadow">
                <div class="px-6 py-4">
                    <h2 class="text-xl font-semibold">@yield('header')</h2>
                </div>
            </header>

            <main class="p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>