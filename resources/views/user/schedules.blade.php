@extends('user.layouts.app')

@section('title', 'Jadwal')

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white py-16 md:py-20 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-20 w-28 h-28 border-4 border-green-500 rounded-full"></div>
            <div class="absolute bottom-10 right-20 w-20 h-20 border-4 border-amber-500 rounded-xl rotate-12"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-block px-4 py-2 bg-gradient-to-r from-green-500/20 to-amber-500/20 text-green-400 rounded-full text-sm font-medium mb-4 border border-green-500/30">
                📅 Jadwal Tersedia
            </span>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                Pilih <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 via-amber-400 to-green-400">Jadwal</span> Anda
            </h1>
            <p class="text-lg text-gray-300 max-w-2xl mx-auto">
                Lihat ketersediaan jadwal photo booth kami dan pilih waktu yang sesuai dengan acara Anda.
            </p>
        </div>
    </section>

    <!-- Schedule Section -->
    <section class="py-12 md:py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filter Bar -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6 mb-8">
                <form action="{{ route('schedules') }}" method="GET" class="flex flex-col md:flex-row md:items-end gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Filter Tanggal</label>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Dari</label>
                                <input type="date" name="from" value="{{ request('from') }}"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-colors text-sm">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Sampai</label>
                                <input type="date" name="to" value="{{ request('to') }}"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-colors text-sm">
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-green-600 to-amber-500 hover:from-green-500 hover:to-amber-400 text-white rounded-xl font-medium transition-all duration-300 shadow-md text-sm">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Filter
                            </span>
                        </button>
                        @if(request('from') || request('to'))
                            <a href="{{ route('schedules') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium transition-colors text-sm">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Schedule Info -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-900">Jadwal Mendatang</h2>
                    <p class="text-gray-600 text-sm mt-1">
                        Menampilkan {{ $schedules->count() }} dari {{ $schedules->total() }} jadwal
                    </p>
                </div>
                <div class="flex items-center gap-4 text-sm">
                    <span class="flex items-center text-green-600">
                        <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                        Tersedia
                    </span>
                    <span class="flex items-center text-gray-500">
                        <span class="w-3 h-3 bg-gray-300 rounded-full mr-2"></span>
                        Penuh
                    </span>
                </div>
            </div>

            @if($schedules->count() > 0)
                <!-- Schedule Grid -->
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                    @foreach($schedules as $schedule)
                        @php
                            $isAvailable = $schedule->isAvailable();
                        @endphp
                        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden {{ !$isAvailable ? 'opacity-60' : 'hover:border-green-200' }}">
                            <!-- Date Header -->
                            <div class="bg-gradient-to-r from-gray-900 to-gray-800 text-white p-4 text-center relative">
                                <!-- Status Badge -->
                                <div class="absolute top-3 right-3">
                                    @if($isAvailable)
                                        <span class="inline-flex items-center px-2 py-1 bg-gradient-to-r from-green-500 to-green-600 text-white text-xs font-medium rounded-full shadow-sm">
                                            Tersedia
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 bg-gray-500 text-white text-xs font-medium rounded-full">
                                            Penuh
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="text-amber-400 text-sm font-medium uppercase tracking-wide">
                                    {{ $schedule->event_date->locale('id')->isoFormat('dddd') }}
                                </div>
                                <div class="text-4xl font-bold mt-1">
                                    {{ $schedule->event_date->format('d') }}
                                </div>
                                <div class="text-gray-300 text-sm">
                                    {{ $schedule->event_date->locale('id')->isoFormat('MMMM YYYY') }}
                                </div>
                            </div>
                            
                            <!-- Schedule Details -->
                            <div class="p-5">
                                <!-- Time -->
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-gradient-to-br from-green-100 to-green-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-xs text-gray-500">Waktu</div>
                                        <div class="font-semibold text-gray-900 text-sm">
                                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }} WIB
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Duration -->
                                <div class="flex items-center mb-5">
                                    <div class="w-10 h-10 bg-gradient-to-br from-amber-100 to-amber-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-xs text-gray-500">Durasi</div>
                                        <div class="font-semibold text-gray-900 text-sm">
                                            @php
                                                $start = \Carbon\Carbon::parse($schedule->start_time);
                                                $end = \Carbon\Carbon::parse($schedule->end_time);
                                                $duration = $start->diffInHours($end);
                                            @endphp
                                            {{ $duration }} Jam
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Action Button -->
                                @if($isAvailable)
                                    <a href="{{ route('booking.create') }}" 
                                       class="block w-full text-center bg-gradient-to-r from-gray-900 to-green-600 hover:from-gray-800 hover:to-green-500 text-white py-3 rounded-xl font-semibold transition-all duration-300 shadow-lg shadow-green-500/20 hover:shadow-xl text-sm">
                                        Pesan Jadwal Ini
                                    </a>
                                @else
                                    <button disabled 
                                            class="block w-full text-center bg-gray-200 text-gray-500 py-3 rounded-xl font-semibold cursor-not-allowed text-sm">
                                        Jadwal Penuh
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $schedules->appends(request()->query())->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Jadwal Tersedia</h3>
                    <p class="text-gray-500 mb-6">
                        @if(request('from') || request('to'))
                            Tidak ada jadwal dalam rentang tanggal yang dipilih.
                        @else
                            Jadwal photo booth akan segera diperbarui. Silakan hubungi kami untuk informasi lebih lanjut.
                        @endif
                    </p>
                    @if(request('from') || request('to'))
                        <a href="{{ route('schedules') }}"
                           class="inline-flex items-center bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-semibold transition-all duration-300 mr-3">
                            Reset Filter
                        </a>
                    @endif
                    <a href="https://wa.me/6283173043030" target="_blank"
                       class="inline-flex items-center bg-gradient-to-r from-green-500 to-amber-500 hover:from-green-400 hover:to-amber-400 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        Hubungi Kami
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Info Section -->
    <section class="py-12 md:py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-6 md:gap-8">
                <!-- Info Card 1 -->
                <div class="text-center p-6 bg-gray-50 rounded-2xl hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-md">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Booking Mudah</h3>
                    <p class="text-gray-600 text-sm">Pilih jadwal dan konfirmasi pemesanan dalam hitungan menit</p>
                </div>
                
                <!-- Info Card 2 -->
                <div class="text-center p-6 bg-gray-50 rounded-2xl hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-md">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Konfirmasi Cepat</h3>
                    <p class="text-gray-600 text-sm">Dapatkan konfirmasi pemesanan dalam waktu 1x24 jam</p>
                </div>
                
                <!-- Info Card 3 -->
                <div class="text-center p-6 bg-gray-50 rounded-2xl hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-amber-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-md">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Support 24/7</h3>
                    <p class="text-gray-600 text-sm">Tim kami siap membantu kapanpun Anda butuhkan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-12 md:py-16 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="bg-gradient-to-r from-green-600 via-green-500 to-amber-500 rounded-2xl p-8 md:p-10 text-white shadow-xl">
                <h2 class="text-2xl md:text-3xl font-bold mb-3">Tidak Menemukan Jadwal yang Cocok?</h2>
                <p class="text-green-100 mb-6">Hubungi kami untuk mengatur jadwal khusus sesuai kebutuhan acara Anda</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="https://wa.me/6283173043030" target="_blank"
                       class="inline-flex items-center justify-center bg-white text-green-600 hover:bg-gray-100 px-6 py-3 rounded-xl font-semibold transition-all duration-300 shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        Chat WhatsApp
                    </a>
                    <a href="{{ route('contact') }}" 
                       class="inline-flex items-center justify-center bg-white/20 hover:bg-white/30 text-white px-6 py-3 rounded-xl font-semibold border border-white/30 transition-all duration-300">
                        Halaman Kontak
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection