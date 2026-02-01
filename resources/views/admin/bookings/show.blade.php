@extends('admin.layouts.app')

@section('title', 'Detail Pemesanan')
@section('header', 'Detail Pemesanan')

@section('content')
    <div class="max-w-4xl">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-4 md:px-6 py-4 flex flex-col md:flex-row justify-between items-start md:items-center text-white gap-3">
                <div>
                    <p class="text-blue-100 text-sm">Pemesanan #{{ $booking->id }}</p>
                    <p class="text-sm opacity-75">Dibuat: {{ $booking->created_at->format('d M Y H:i') }}</p>
                </div>
                <div class="text-left md:text-right">
                    <div class="text-3xl font-bold">{{ $booking->queue_number }}</div>
                    <div class="text-sm text-blue-100">Urutan #{{ $booking->sequence }}</div>
                </div>
            </div>

            <div class="p-4 md:p-6">
                <!-- Customer & Schedule Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-gray-50 rounded-xl p-4">
                        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Info Pelanggan
                        </h3>
                        <p class="mb-1"><span class="text-gray-500">Nama:</span> <span class="font-semibold">{{ $booking->user->name }}</span></p>
                        <p class="mb-1"><span class="text-gray-500">Telepon:</span> <span class="font-semibold">{{ $booking->user->phone_number ?? '-' }}</span></p>
                        @if($booking->notes)
                            <div class="mt-3 bg-yellow-50 border border-yellow-100 p-3 rounded-lg text-sm">
                                <span class="font-medium text-yellow-800">Catatan:</span> 
                                <span class="text-yellow-700">{{ $booking->notes }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4">
                        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Info Jadwal
                        </h3>
                        <p class="mb-1"><span class="text-gray-500">Tanggal:</span> <span class="font-semibold">{{ $booking->schedule->event_date->format('d F Y') }}</span></p>
                        <p class="mb-1"><span class="text-gray-500">Est. Slot:</span> <span class="font-semibold">{{ $booking->time_slot }}</span></p>
                        <p class="mb-1 flex items-center gap-2">
                            <span class="text-gray-500">Status:</span>
                            @php
                                $statusColors = [
                                    'booked' => 'bg-blue-100 text-blue-800',
                                    'skipped' => 'bg-yellow-100 text-yellow-800',
                                    'processing' => 'bg-purple-100 text-purple-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                    'pending' => 'bg-gray-100 text-gray-800',
                                ];
                                $statusLabels = [
                                    'pending' => 'Menunggu',
                                    'booked' => 'Dipesan',
                                    'skipped' => 'Dilewati',
                                    'processing' => 'Proses',
                                    'completed' => 'Selesai',
                                    'cancelled' => 'Dibatalkan',
                                ];
                            @endphp
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $statusLabels[$booking->status] ?? ucfirst($booking->status) }}
                            </span>
                        </p>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="mb-6">
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        Ringkasan Pesanan
                    </h3>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="flex justify-between mb-2">
                            <span>Layanan: <b>{{ $booking->service->name }}</b></span>
                            <span class="font-semibold">Rp {{ number_format($booking->service->price, 0, ',', '.') }}</span>
                        </div>

                        @foreach($booking->addons as $addon)
                            <div class="flex justify-between mb-2 text-sm text-gray-600">
                                <span>+ {{ $addon->name }} (x{{ $addon->pivot->quantity }})</span>
                                <span>Rp {{ number_format($addon->pivot->price * $addon->pivot->quantity, 0, ',', '.') }}</span>
                            </div>
                        @endforeach

                        @if($booking->promo)
                            <div class="flex justify-between mb-2 text-green-600 font-medium">
                                <span>Promo: {{ $booking->promo->code }}</span>
                                <span>- Rp {{ number_format($booking->promo->discount_amount ?? 0, 0, ',', '.') }}</span>
                            </div>
                        @endif

                        <div class="border-t-2 border-dashed mt-3 pt-3 flex justify-between font-bold text-lg">
                            <span>Total Harga</span>
                            <span class="text-blue-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Items -->
                <div class="mb-6">
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Hasil Item (Output)
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($booking->items as $item)
                            <span class="bg-yellow-100 text-yellow-800 text-sm font-bold px-3 py-1.5 rounded-full border border-yellow-200">
                                {{ $item->pivot->quantity }}x {{ $item->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-gray-50 border-t border-gray-100 px-4 md:px-6 py-4">
                <div class="flex flex-col md:flex-row gap-3 items-start md:items-center">
                    <form action="{{ route('admin.bookings.status', $booking) }}" method="POST" class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="border border-gray-200 px-4 py-2.5 rounded-xl bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                            @foreach(['pending', 'booked', 'skipped', 'completed', 'cancelled'] as $status)
                                @php
                                    $labels = ['pending' => 'Menunggu', 'booked' => 'Dipesan', 'skipped' => 'Dilewati', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'];
                                @endphp
                                <option value="{{ $status }}" {{ $booking->status === $status ? 'selected' : '' }}>
                                    {{ $labels[$status] }}
                                </option>
                            @endforeach
                        </select>
                        <button class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-5 py-2.5 rounded-xl font-medium shadow-lg transition-all">
                            Perbarui Status
                        </button>
                    </form>

                    @if($booking->status === 'skipped')
                        <form action="{{ route('admin.bookings.move-to-top', $booking) }}" method="POST">
                            @csrf
                            <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2.5 rounded-xl font-medium transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                </svg>
                                Pindah ke Atas
                            </button>
                        </form>
                    @endif

                    @if($booking->status === 'completed')
                        <form action="{{ route('admin.bookings.send-result', $booking) }}" method="POST">
                            @csrf
                            <button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2.5 rounded-xl font-medium transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Kirim Foto
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('admin.bookings.index') }}" class="md:ml-auto text-gray-600 hover:text-gray-800 font-medium flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection