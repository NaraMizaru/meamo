@extends('user.layouts.dashboard')

@section('title', 'Dashboard')
@section('header', 'Ringkasan')

@section('content')
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl shadow-lg mb-6 overflow-hidden">
        <div class="p-6 md:p-8 text-white relative">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
            <div class="relative">
                <h1 class="text-xl md:text-2xl font-bold mb-2">
                    Selamat datang kembali, <span class="text-blue-200">{{ Auth::user()->name }}</span>! 👋
                </h1>
                <p class="text-blue-100 text-sm md:text-base">Kelola pemesanan foto Anda dengan mudah di sini.</p>
            </div>
            @if(!Auth::user()->phone_number)
                <div class="mt-4 p-4 bg-yellow-500/20 border border-yellow-300/30 text-yellow-100 rounded-xl flex items-start gap-3">
                    <svg class="w-6 h-6 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                    <p class="text-sm">Silakan <a href="{{ route('profile.edit') }}" class="underline font-bold hover:text-white">tambahkan
                            nomor telepon Anda</a> untuk melengkapi profil dan mulai melakukan pemesanan.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Next Booking Section -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-4">
            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Booking Saya Berikutnya
            </h3>
            <a href="{{ route('booking.create') }}"
                class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium shadow-lg shadow-blue-500/25 transition-all duration-200 flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Pemesanan Baru
            </a>
        </div>

        @if($next_booking)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-4 md:px-6 py-5 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 text-white">
                    <div>
                        <span class="text-blue-200 text-xs font-bold uppercase tracking-wider">Nomor Antrian</span>
                        <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight">{{ $next_booking->queue_number }}</h2>
                    </div>
                    <div class="sm:text-right">
                        <div class="mb-1">
                            <span class="text-blue-200 text-xs font-bold uppercase tracking-wider block sm:inline">Tanggal Jadwal</span>
                            <p class="text-xl md:text-2xl font-bold inline sm:block">{{ $next_booking->schedule->event_date->format('d M Y') }}</p>
                        </div>
                        <div class="flex items-center sm:justify-end text-blue-100 gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-xs uppercase font-bold tracking-wider mr-1">Waktu:</span>
                            <p class="font-medium text-white">{{ $next_booking->time_slot }}</p>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-4 md:p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-10">
                        <!-- Left: Service Details -->
                        <div>
                            <h4 class="text-gray-400 uppercase text-xs font-bold tracking-wider mb-4 border-b pb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                Detail Layanan
                            </h4>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                                    <span class="text-gray-700 font-medium">{{ $next_booking->service->name }}</span>
                                    <span class="font-bold text-gray-800">Rp {{ number_format($next_booking->service->price, 0, ',', '.') }}</span>
                                </div>
                                @foreach($next_booking->addons as $addon)
                                    <div class="flex justify-between items-center text-sm text-gray-500 px-3">
                                        <span>+ {{ $addon->name }} (x{{ $addon->pivot->quantity }})</span>
                                        <span>Rp {{ number_format($addon->pivot->price * $addon->pivot->quantity, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                                @if($next_booking->promo)
                                    <div class="bg-green-50 text-green-700 px-4 py-3 rounded-xl flex justify-between items-center text-sm font-medium border border-green-100">
                                        <span class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                            </svg>
                                            Promo ({{ $next_booking->promo->code }})
                                        </span>
                                        <span>- Potongan Harga</span>
                                    </div>
                                @endif
                                <div class="flex justify-between items-center pt-4 mt-2 border-t-2 border-dashed border-gray-200">
                                    <span class="text-xl font-extrabold text-gray-900">Total</span>
                                    <span class="text-xl font-extrabold text-blue-600">Rp {{ number_format($next_booking->total_price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Items & Notes -->
                        <div>
                            <h4 class="text-gray-400 uppercase text-xs font-bold tracking-wider mb-4 border-b pb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Item yang Didapat
                            </h4>
                            <div class="flex flex-wrap gap-2 mb-6">
                                @foreach($next_booking->items as $item)
                                    <span class="bg-gradient-to-r from-indigo-50 to-blue-50 text-indigo-700 text-sm font-bold px-4 py-2 rounded-full border border-indigo-100 shadow-sm">
                                        {{ $item->pivot->quantity }}x {{ $item->name }}
                                    </span>
                                @endforeach
                            </div>

                            @if(in_array($next_booking->status, ['booked', 'skipped']))
                                <div class="mb-6">
                                    <a href="{{ route('booking.edit', $next_booking->id) }}" class="w-full flex items-center justify-center gap-2 bg-white border-2 border-blue-500 text-blue-600 font-bold py-3 rounded-xl hover:bg-blue-50 transition-colors shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit Pesanan
                                    </a>
                                </div>
                            @endif

                            @if($next_booking->notes)
                                <h4 class="text-gray-400 uppercase text-xs font-bold tracking-wider mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                    </svg>
                                    Catatan Anda
                                </h4>
                                <div class="bg-amber-50 border border-amber-100 rounded-xl p-4 text-gray-700 text-sm italic">
                                    "{{ $next_booking->notes }}"
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 text-center border-2 border-dashed border-gray-200">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Tidak ada jadwal booking aktif</h3>
                <p class="text-gray-500 mb-6">Buat pemesanan baru untuk mengabadikan momen spesial Anda.</p>
                <a href="{{ route('booking.create') }}"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-blue-500/25 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Buat Pemesanan Sekarang
                </a>
            </div>
        @endif
    </div>

    <!-- Upcoming Queue -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="p-4 md:p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                Antrian Booking Selanjutnya
            </h3>
        </div>

        <!-- Desktop Table (hidden on mobile) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Layanan</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Jadwal</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Antrian</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($upcoming_queue as $booking)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $booking->service->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $booking->schedule->event_date->format('d M Y') }} <br>
                                <span class="text-xs text-gray-400">{{ $booking->time_slot }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-mono font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-lg">{{ $booking->queue_number }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if(in_array($booking->status, ['booked', 'skipped']))
                                    <a href="{{ route('booking.edit', $booking->id) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">Edit</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">Tidak ada booking lain dalam antrian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards (hidden on desktop) -->
        <div class="md:hidden divide-y divide-gray-100">
            @forelse($upcoming_queue as $booking)
                <div class="p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ $booking->service->name }}</h4>
                            <p class="text-sm text-gray-500">{{ $booking->schedule->event_date->format('d M Y') }} • {{ $booking->time_slot }}</p>
                        </div>
                        <span class="font-mono font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-lg text-sm">{{ $booking->queue_number }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ ucfirst($booking->status) }}
                        </span>
                        @if(in_array($booking->status, ['booked', 'skipped']))
                            <a href="{{ route('booking.edit', $booking->id) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-semibold">Edit</a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-sm text-gray-500">Tidak ada booking lain dalam antrian.</div>
            @endforelse
        </div>

        <div class="bg-gray-50 px-4 md:px-6 py-4 border-t border-gray-100 text-center">
            <a href="{{ route('bookings.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm inline-flex items-center gap-1">
                Lihat Semua Riwayat Pesanan
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
@endsection