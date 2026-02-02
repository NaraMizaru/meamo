@extends('user.layouts.app')

@section('title', 'Layanan')

@section('content')
    <!-- Hero Section -->
    <section
        class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white py-16 md:py-20 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 right-20 w-32 h-32 border-4 border-green-500 rounded-full"></div>
            <div class="absolute bottom-10 left-20 w-24 h-24 border-4 border-green-500 rounded-xl rotate-45"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-block px-4 py-2 bg-green-500/20 text-green-400 rounded-full text-sm font-medium mb-4">
                📸 Paket Layanan
            </span>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                Layanan <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-green-600">Photo
                    Booth</span> Kami
            </h1>
            <p class="text-lg text-gray-300 max-w-2xl mx-auto">
                Pilih paket yang sesuai dengan kebutuhan acara Anda. Semua paket termasuk operator profesional dan hasil
                cetak berkualitas.
            </p>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-12 md:py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Services Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                @foreach($services as $service)
                    <div
                        class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-green-200 relative">
                        <!-- Popular Badge (Optional - for first item) -->
                        @if($loop->first)
                            <div class="absolute top-4 right-4 z-10">
                                <span
                                    class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-green-500 to-green-600 text-white text-xs font-semibold rounded-full shadow-lg">
                                    ⭐ Populer
                                </span>
                            </div>
                        @endif

                        <!-- Header Gradient -->
                        <div class="h-2 bg-gradient-to-r from-green-500 to-green-600"></div>

                        <div class="p-6 md:p-8">
                            <!-- Icon -->
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-green-100 to-green-50 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>

                            <!-- Service Name -->
                            <h2 class="text-2xl font-bold text-gray-900 mb-3">{{ $service->name }}</h2>

                            <!-- Description -->
                            <p class="text-gray-600 mb-6 leading-relaxed">{{ $service->description }}</p>

                            <!-- Features List -->
                            <ul class="space-y-3 mb-8">
                                <li class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Operator profesional
                                </li>
                                <li class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Properti lengkap
                                </li>
                            </ul>

                            <!-- Price -->
                            <div class="border-t border-gray-100 pt-6">
                                <div class="flex items-end justify-between mb-4">
                                    <div>
                                        <span class="text-sm text-gray-500">Mulai dari</span>
                                        <div class="text-3xl font-bold text-gray-900">
                                            Rp {{ number_format($service->price, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>

                                <a href="{{ route('booking.create') }}"
                                    class="block w-full text-center bg-gradient-to-r from-gray-900 to-green-600 hover:from-gray-800 hover:to-green-500 text-white py-3.5 rounded-xl font-semibold transition-all duration-300 shadow-lg shadow-green-500/20 hover:shadow-xl hover:shadow-green-500/30">
                                    Pilih Paket Ini
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Additional Info Section -->
    <section class="py-12 md:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-8 md:gap-12 items-center">
                <!-- Left Content -->
                <div>
                    <span
                        class="inline-block px-4 py-2 bg-gradient-to-r from-green-100 to-amber-100 text-green-700 rounded-full text-sm font-medium mb-4">
                        ✨ Semua Paket Termasuk
                    </span>
                    <h2 class="text-2xl md:text-4xl font-bold text-gray-900 mb-4 md:mb-6">Fasilitas <span
                            class="text-amber-500">Lengkap</span> untuk Setiap Paket</h2>
                    <p class="text-base md:text-lg text-gray-600 mb-6 md:mb-8">
                        Kami memberikan pengalaman photo booth terbaik dengan fasilitas premium yang sudah termasuk dalam
                        setiap paket.
                    </p>

                    <!-- Features Grid - Single column on mobile, 2 cols on sm+ -->
                    <div class="space-y-4 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-4">
                        <div class="flex items-center p-3 bg-gray-50 rounded-xl">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-md">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="font-semibold text-gray-900 text-sm">Setup Gratis</h4>
                                <p class="text-xs text-gray-500">Tim kami yang handle</p>
                            </div>
                        </div>

                        <div class="flex items-center p-3 bg-gray-50 rounded-xl">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-md">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="font-semibold text-gray-900 text-sm">Backdrop</h4>
                                <p class="text-xs text-gray-500">Berbagai terbaik</p>
                            </div>
                        </div>

                        <div class="flex items-center p-3 bg-gray-50 rounded-xl">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-green-500 to-amber-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-md">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="font-semibold text-gray-900 text-sm">Properti Lucu</h4>
                                <p class="text-xs text-gray-500">Backdrop, dll</p>
                            </div>
                        </div>

                        <div class="flex items-center p-3 bg-gray-50 rounded-xl">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-amber-500 to-green-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-md">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="font-semibold text-gray-900 text-sm">Hasil Cetak</h4>
                                <p class="text-xs text-gray-500">Cetak foto</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right - Decorative -->
                <div class="relative hidden md:block">
                    <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-3xl p-8 relative overflow-hidden">
                        <!-- Pattern -->
                        <div class="absolute top-4 right-4 w-20 h-20 border-4 border-green-500/30 rounded-full"></div>
                        <div class="absolute bottom-4 left-4 w-16 h-16 border-4 border-amber-500/30 rounded-xl rotate-45">
                        </div>

                        <div class="relative text-white text-center py-12">
                            <div
                                class="w-20 h-20 bg-gradient-to-br from-green-500 to-amber-500 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-green-500/30">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold mb-2">Kualitas <span class="text-amber-400">Premium</span></h3>
                            <p class="text-gray-400">Hasil terbaik untuk momen spesial Anda</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-12 md:py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-3xl p-8 md:p-12 relative overflow-hidden">
                <!-- Pattern -->
                <div class="absolute top-4 right-10 w-20 h-20 border-4 border-green-500/20 rounded-full"></div>
                <div class="absolute bottom-4 left-10 w-16 h-16 border-4 border-green-500/20 rounded-xl rotate-45"></div>

                <div class="relative text-white">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Ada Pertanyaan Lain?</h2>
                    <p class="text-lg text-gray-300 mb-8 max-w-2xl mx-auto">
                        Tim kami siap membantu. Hubungi kami via WhatsApp untuk konsultasi gratis!
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="https://wa.me/6283173043030" target="_blank"
                            class="inline-flex items-center justify-center bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-xl font-semibold text-lg transition-all duration-300 shadow-lg shadow-green-500/30">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                            </svg>
                            Chat WhatsApp
                        </a>
                        <a href="{{ route('contact') }}"
                            class="inline-flex items-center justify-center bg-white/10 hover:bg-white/20 text-white px-8 py-4 rounded-xl font-semibold text-lg border border-white/20 transition-all duration-300">
                            Lihat Kontak Lain
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection