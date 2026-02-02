@extends('user.layouts.app')

@section('title', 'Beranda')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-10 w-32 h-32 border-4 border-green-500 rounded-full"></div>
            <div class="absolute top-40 right-20 w-24 h-24 border-4 border-amber-500 rounded-xl rotate-45"></div>
            <div class="absolute bottom-20 left-1/4 w-20 h-20 border-4 border-green-500 rounded-full"></div>
            <div class="absolute bottom-10 right-1/3 w-16 h-16 border-4 border-amber-500 rounded-xl rotate-12"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-32">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="text-center md:text-left">
                    <span
                        class="inline-block px-4 py-2 bg-gradient-to-r from-green-500/20 to-amber-500/20 text-green-400 rounded-full text-sm font-medium mb-6 border border-green-500/30">
                        ✨ Photo Booth Profesional
                    </span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                        Abadikan Momen
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 via-amber-400 to-green-400">Berharga</span>
                        Anda
                    </h1>
                    <p class="text-lg md:text-xl text-gray-300 mb-8 max-w-lg">
                        Ciptakan kenangan tak terlupakan dengan layanan photo booth modern kami. Kualitas premium untuk
                        setiap momen spesial.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                        @if(!Auth::check() || !Auth::user()->isAdmin())
                            <a href="{{ route('booking.create') }}"
                                class="inline-flex items-center justify-center bg-gradient-to-r from-green-500 to-amber-500 hover:from-green-400 hover:to-amber-400 text-white px-8 py-4 rounded-xl font-semibold text-lg shadow-lg shadow-green-500/30 transition-all duration-300 hover:shadow-xl hover:shadow-green-500/40 hover:-translate-y-1">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Pesan Sekarang
                            </a>
                        @endif
                        <a href="https://wa.me/6283173043030" target="_blank"
                            class="inline-flex items-center justify-center bg-white/10 hover:bg-white/20 text-white px-8 py-4 rounded-xl font-semibold text-lg border border-white/20 transition-all duration-300">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                            </svg>
                            Chat WhatsApp
                        </a>
                    </div>
                </div>

                <!-- Hero Image/Illustration -->
                <div class="relative hidden md:block">
                    <div class="relative w-full aspect-square max-w-md mx-auto">
                        <!-- Camera Frame -->
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-green-500/20 to-amber-500/20 rounded-3xl rotate-6">
                        </div>
                        <div
                            class="absolute inset-4 bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl flex items-center justify-center border border-green-500/30">
                            <div class="text-center p-8">
                                <div
                                    class="w-24 h-24 mx-auto mb-4 bg-gradient-to-br from-green-500 to-amber-500 rounded-full flex items-center justify-center shadow-lg shadow-green-500/30">
                                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <p class="text-gray-400 text-sm">Momen Sempurna</p>
                            </div>
                        </div>
                        <!-- Floating Elements -->
                        <div
                            class="absolute -top-4 -right-4 w-20 h-20 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-amber-500/30 animate-pulse">
                            HD
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wave Decoration -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z"
                    fill="#F9FAFB" />
            </svg>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 md:py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 md:mb-16">
                <span
                    class="inline-block px-4 py-2 bg-gradient-to-r from-green-100 to-amber-100 text-green-700 rounded-full text-sm font-medium mb-4">
                    ⭐ Mengapa Memilih Kami
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Keunggulan <span
                        class="text-green-600">Mea</span>Booth</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Kami memberikan pengalaman photo booth terbaik dengan
                    teknologi modern dan layanan profesional</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                <!-- Feature 1 -->
                <div
                    class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-green-200 relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-green-500/10 to-amber-500/10 rounded-bl-full transform translate-x-10 -translate-y-10 group-hover:translate-x-0 group-hover:translate-y-0 transition-transform duration-500">
                    </div>
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mb-5 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg shadow-green-500/20">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Kualitas HD</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Hasil foto berkualitas tinggi dengan resolusi HD yang
                        jernih dan tajam untuk setiap momen</p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-amber-200 relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-amber-500/10 to-green-500/10 rounded-bl-full transform translate-x-10 -translate-y-10 group-hover:translate-x-0 group-hover:translate-y-0 transition-transform duration-500">
                    </div>
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center mb-5 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg shadow-amber-500/20">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Hasil Instan</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Cetak foto langsung di tempat dalam hitungan detik
                        setelah sesi pemotretan</p>
                </div>

                <!-- Feature 3 -->
                <div
                    class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-green-200 relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-green-500/10 to-amber-500/10 rounded-bl-full transform translate-x-10 -translate-y-10 group-hover:translate-x-0 group-hover:translate-y-0 transition-transform duration-500">
                    </div>
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-green-500 to-amber-500 rounded-xl flex items-center justify-center mb-5 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg shadow-green-500/20">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Template Beragam</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Koleksi template cantik yang bisa disesuaikan dengan
                        tema acara Anda</p>
                </div>

                <!-- Feature 4 -->
                <div
                    class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-amber-200 relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-amber-500/10 to-green-500/10 rounded-bl-full transform translate-x-10 -translate-y-10 group-hover:translate-x-0 group-hover:translate-y-0 transition-transform duration-500">
                    </div>
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-amber-500 to-green-500 rounded-xl flex items-center justify-center mb-5 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg shadow-amber-500/20">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Tim Profesional</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Operator berpengalaman siap membantu untuk hasil foto
                        terbaik</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-16 md:py-24 bg-white relative overflow-hidden">
        <!-- Background decoration -->
        <div
            class="absolute top-0 left-0 w-64 h-64 bg-gradient-to-br from-green-500/5 to-amber-500/5 rounded-full -translate-x-1/2 -translate-y-1/2">
        </div>
        <div
            class="absolute bottom-0 right-0 w-96 h-96 bg-gradient-to-tl from-amber-500/5 to-green-500/5 rounded-full translate-x-1/2 translate-y-1/2">
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 md:mb-16">
                <span
                    class="inline-block px-4 py-2 bg-gradient-to-r from-green-100 to-amber-100 text-green-700 rounded-full text-sm font-medium mb-4">
                    📦 Layanan Kami
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Pilihan <span
                        class="text-amber-500">Paket</span> Photo Booth</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Temukan paket yang sesuai dengan kebutuhan acara Anda</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                @foreach($services as $service)
                    <div
                        class="group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-green-200 hover:-translate-y-2">
                        <div class="h-2 bg-gradient-to-r from-green-500 via-amber-500 to-green-500"></div>
                        <div class="p-6">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-green-100 to-amber-100 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $service->name }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ Str::limit($service->description, 80) }}</p>
                            <div class="flex items-baseline mb-4">
                                <span
                                    class="text-2xl font-bold bg-gradient-to-r from-green-600 to-amber-600 bg-clip-text text-transparent">Rp
                                    {{ number_format($service->price, 0, ',', '.') }}</span>
                            </div>
                            <a href="{{ route('booking.create') }}"
                                class="block w-full text-center bg-gray-100 hover:bg-gradient-to-r hover:from-green-500 hover:to-amber-500 text-gray-700 hover:text-white py-3 rounded-xl font-semibold transition-all duration-300">
                                Pilih Paket
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-10">
                <a href="{{ route('services') }}"
                    class="inline-flex items-center text-green-600 hover:text-amber-600 font-semibold transition-colors group">
                    Lihat Semua Layanan
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-16 md:py-24 bg-gradient-to-br from-gray-50 via-white to-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 md:mb-16">
                <span
                    class="inline-block px-4 py-2 bg-gradient-to-r from-amber-100 to-green-100 text-amber-700 rounded-full text-sm font-medium mb-4">
                    🚀 Cara Pemesanan
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Mudah & <span
                        class="text-green-600">Cepat</span></h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Ikuti langkah sederhana berikut untuk memesan layanan
                    photo booth kami</p>
            </div>

            <div class="grid md:grid-cols-4 gap-8">
                <!-- Step 1 -->
                <div class="relative text-center group">
                    <div
                        class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-5 text-white text-2xl font-bold shadow-xl shadow-green-500/30 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        1
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Pilih Layanan</h3>
                    <p class="text-gray-600 text-sm">Pilih paket photo booth yang sesuai dengan kebutuhan acara Anda</p>
                    <div
                        class="hidden md:block absolute top-10 left-[60%] w-[80%] h-1 bg-gradient-to-r from-green-300 via-amber-300 to-green-100 rounded-full">
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="relative text-center group">
                    <div
                        class="w-20 h-20 bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl flex items-center justify-center mx-auto mb-5 text-white text-2xl font-bold shadow-xl shadow-amber-500/30 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        2
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Pilih Jadwal</h3>
                    <p class="text-gray-600 text-sm">Tentukan tanggal dan waktu acara sesuai jadwal yang tersedia</p>
                    <div
                        class="hidden md:block absolute top-10 left-[60%] w-[80%] h-1 bg-gradient-to-r from-amber-300 via-green-300 to-amber-100 rounded-full">
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="relative text-center group">
                    <div
                        class="w-20 h-20 bg-gradient-to-br from-green-500 to-amber-500 rounded-2xl flex items-center justify-center mx-auto mb-5 text-white text-2xl font-bold shadow-xl shadow-green-500/30 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        3
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Konfirmasi</h3>
                    <p class="text-gray-600 text-sm">Lakukan pembayaran dan tunggu konfirmasi dari tim kami</p>
                    <div
                        class="hidden md:block absolute top-10 left-[60%] w-[80%] h-1 bg-gradient-to-r from-green-300 via-amber-300 to-green-100 rounded-full">
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="text-center group">
                    <div
                        class="w-20 h-20 bg-gradient-to-br from-amber-500 to-green-500 rounded-2xl flex items-center justify-center mx-auto mb-5 text-white text-2xl font-bold shadow-xl shadow-amber-500/30 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        4
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Nikmati!</h3>
                    <p class="text-gray-600 text-sm">Photo booth siap di lokasi Anda. Saatnya bersenang-senang!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 md:py-24 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div
                class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 rounded-3xl p-8 md:p-12 relative overflow-hidden shadow-2xl">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-20">
                    <div class="absolute top-4 right-10 w-20 h-20 border-4 border-green-500 rounded-full"></div>
                    <div class="absolute bottom-4 left-10 w-16 h-16 border-4 border-amber-500 rounded-xl rotate-45"></div>
                    <div class="absolute top-1/2 left-1/4 w-12 h-12 border-4 border-amber-500 rounded-full"></div>
                </div>

                <div class="relative">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-500 to-amber-500 rounded-2xl mb-6 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Siap Membuat Momen Spesial?</h2>
                    <p class="text-lg text-gray-300 mb-8 max-w-2xl mx-auto">
                        Hubungi kami sekarang dan dapatkan penawaran terbaik untuk acara Anda
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        @if(!Auth::check() || !Auth::user()->isAdmin())
                            <a href="{{ route('booking.create') }}"
                                class="inline-flex items-center justify-center bg-gradient-to-r from-green-500 to-amber-500 hover:from-green-400 hover:to-amber-400 text-white px-8 py-4 rounded-xl font-semibold text-lg shadow-lg transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                                Pesan Sekarang
                            </a>
                        @endif
                        <a href="https://wa.me/6283173043030" target="_blank"
                            class="inline-flex items-center justify-center bg-white/10 hover:bg-white/20 text-white px-8 py-4 rounded-xl font-semibold text-lg border border-white/20 transition-all duration-300">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                            </svg>
                            Chat WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection