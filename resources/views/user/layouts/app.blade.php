<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Beranda') - Meamo Photo Booth</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">

    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">Meamo</a>

                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}"
                        class="{{ request()->routeIs('home') ? 'text-blue-600 font-semibold' : 'text-gray-700' }}">Beranda</a>
                    <a href="{{ route('templates') }}"
                        class="{{ request()->routeIs('templates') ? 'text-blue-600 font-semibold' : 'text-gray-700' }}">Template</a>
                    <a href="{{ route('gallery') }}"
                        class="{{ request()->routeIs('gallery') ? 'text-blue-600 font-semibold' : 'text-gray-700' }}">Galeri</a>
                    <a href="{{ route('services') }}"
                        class="{{ request()->routeIs('services') ? 'text-blue-600 font-semibold' : 'text-gray-700' }}">Layanan</a>
                    <a href="{{ route('bookings.index') }}"
                        class="{{ request()->routeIs('bookings.index') ? 'text-blue-600 font-semibold' : 'text-gray-700' }}">Booking</a>
                    <a href="{{ route('bookings.history') }}"
                        class="{{ request()->routeIs('bookings.history') ? 'text-blue-600 font-semibold' : 'text-gray-700' }}">Riwayat</a>
                    <a href="{{ route('schedules') }}"
                        class="{{ request()->routeIs('schedules') ? 'text-blue-600 font-semibold' : 'text-gray-700' }}">Jadwal</a>
                    <a href="{{ route('contact') }}"
                        class="{{ request()->routeIs('contact') ? 'text-blue-600 font-semibold' : 'text-gray-700' }}">Kontak</a>
                </div>

                @auth
                    <div class="hidden md:flex items-center space-x-4">
                        <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}"
                            class="text-gray-700 hover:text-blue-600">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-blue-600">Keluar</button>
                        </form>
                        @if(!Auth::user()->isAdmin())
                            <a href="{{ route('booking.create') }}"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                                Pesan Sekarang
                            </a>
                        @endif
                    </div>
                @else
                    <div class="hidden md:flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Masuk</a>
                        <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600">Daftar</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <main>
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 mt-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 mt-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white mt-12">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="grid md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Meamo Photo Booth</h3>
                    <p class="text-gray-400">
                        Abadikan momen berharga Anda dengan layanan photo booth profesional kami.
                    </p>
                </div>

                <div>
                    <h4 class="font-semibold mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('gallery') }}">Galeri</a></li>
                        <li><a href="{{ route('services') }}">Layanan</a></li>
                        <li><a href="{{ route('booking.create') }}">Pesan Sekarang</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold mb-4">Kontak</h4>
                    <ul class="text-gray-400 space-y-2">
                        <li>Email: info@meamo.com</li>
                        <li>Telepon: +62 812-3456-7890</li>
                        <li>WhatsApp: +62 812-3456-7890</li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400">
                &copy; 2026 Meamo Photo Booth
            </div>
        </div>
    </footer>

</body>

</html>