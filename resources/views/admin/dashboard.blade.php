@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-6">
        <div class="bg-white p-4 md:p-6 rounded-2xl shadow-lg border border-gray-100">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-500 text-xs md:text-sm font-medium">Total Pemesanan</h3>
            <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $stats['total_bookings'] }}</p>
        </div>

        <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-4 md:p-6 rounded-2xl shadow-lg text-white">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-blue-100 text-xs md:text-sm font-medium">Dipesan</h3>
            <p class="text-2xl md:text-3xl font-bold">{{ $stats['booked'] }}</p>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-4 md:p-6 rounded-2xl shadow-lg text-white">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-green-100 text-xs md:text-sm font-medium">Selesai</h3>
            <p class="text-2xl md:text-3xl font-bold">{{ $stats['completed'] }}</p>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-indigo-600 p-4 md:p-6 rounded-2xl shadow-lg text-white">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-purple-100 text-xs md:text-sm font-medium">Hari Ini</h3>
            <p class="text-2xl md:text-3xl font-bold">{{ $stats['today'] ?? 0 }}</p>
        </div>
    </div>

    <!-- Next Booking Highlight -->
    <div class="mb-8">
        <h3 class="text-lg font-bold mb-4 text-gray-800 flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
            Booking Selanjutnya
        </h3>
        @if($next_booking)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-4 md:px-6 py-4 flex flex-col md:flex-row justify-between items-start md:items-center text-white gap-3">
                    <div>
                        <span class="text-blue-100 text-xs md:text-sm font-semibold uppercase tracking-wider">Nomor Antrian</span>
                        <h2 class="text-2xl md:text-3xl font-bold">{{ $next_booking->queue_number }}</h2>
                    </div>
                    <div class="text-left md:text-right">
                        <p class="text-lg md:text-xl font-semibold">{{ $next_booking->schedule->event_date->format('d M Y') }}</p>
                        <p class="text-blue-100">{{ $next_booking->time_slot }}</p>
                    </div>
                </div>
                <div class="p-4 md:p-6 grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                    <div>
                        <h4 class="text-gray-500 uppercase text-xs font-bold tracking-wider mb-3">Detail Pelanggan</h4>
                        <div class="flex items-center mb-3">
                            <div class="bg-gray-100 rounded-full p-2 mr-3">
                                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-lg text-gray-900">{{ $next_booking->user->name }}</p>
                                @if($next_booking->user->phone_number)
                                    <a href="{{ $next_booking->user->whatsapp_url }}" target="_blank"
                                        class="text-green-600 hover:text-green-700 font-semibold flex items-center text-sm">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.654-.698c.99.597 2.016 1.018 3.352 1.026v.001c3.181 0 5.768-2.587 5.768-5.766.001-3.182-2.585-5.767-5.764-5.767zM12 18.001h-.008v.001c-1.258.001-2.133-.481-2.909-1.036l-2.062.54.551-2.008C7.152 14.88 6.812 13.924 6.813 13c0-2.863 2.336-5.195 5.201-5.195 2.87 0 5.208 2.336 5.206 5.196-.002 2.862-2.337 5.194-5.214 5.2z">
                                            </path>
                                        </svg>
                                        {{ $next_booking->user->phone_number }}
                                    </a>
                                @else
                                    <span class="text-gray-500 italic text-sm">Tidak ada nomor HP</span>
                                @endif
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-gray-600 text-sm mb-1">Catatan:</p>
                            <p class="text-gray-800 italic">"{{ $next_booking->notes ?? 'Tidak ada catatan.' }}"</p>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-gray-500 uppercase text-xs font-bold tracking-wider mb-3">Detail Pesanan</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                                <span class="text-gray-700 font-medium">{{ $next_booking->service->name }}</span>
                                <span class="font-bold">Rp
                                    {{ number_format($next_booking->service->price, 0, ',', '.') }}</span>
                            </div>
                            @foreach($next_booking->addons as $addon)
                                <div class="flex justify-between items-center text-sm text-gray-600">
                                    <span>+ {{ $addon->name }} (x{{ $addon->pivot->quantity }})</span>
                                    <span>Rp {{ number_format($addon->pivot->price * $addon->pivot->quantity, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                            @if($next_booking->promo)
                                <div
                                    class="flex justify-between items-center text-green-600 text-sm font-medium border-t border-dashed border-gray-200 pt-2">
                                    <span>Promo ({{ $next_booking->promo->code }})</span>
                                    <span>- Diskon</span>
                                </div>
                            @endif
                            <div class="flex justify-between items-center pt-2 mt-2 border-t-2 border-gray-100">
                                <span class="text-lg font-extrabold text-gray-800">Total</span>
                                <span class="text-lg font-extrabold text-blue-600">Rp
                                    {{ number_format($next_booking->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <h5 class="text-xs font-bold text-gray-500 uppercase mb-2">Item (Hasil):</h5>
                            <div class="flex flex-wrap gap-2">
                                @foreach($next_booking->items as $item)
                                    <span
                                        class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2 py-1 rounded-full border border-yellow-200">
                                        {{ $item->pivot->quantity }}x {{ $item->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 md:px-6 py-3 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-3">
                    <div id="action-timer" class="text-sm font-bold text-red-600"></div>

                    <div class="flex flex-wrap gap-2 w-full md:w-auto">
                        @if($next_booking->isProcessing())
                            <div class="flex items-center mr-4" id="countdown-container">
                                <span class="mr-2 text-gray-600 text-sm">Timer:</span>
                                <span id="countdown" class="font-mono text-xl font-bold text-blue-600">--:--</span>
                            </div>

                            <form action="{{ route('admin.bookings.status', $next_booking) }}" method="POST" class="flex-1 md:flex-none">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="completed">
                                <input type="hidden" name="redirect_to" value="admin.dashboard">
                                <button class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl text-sm font-medium transition-colors">
                                    Selesai
                                </button>
                            </form>
                        @else
                             <form action="{{ route('admin.bookings.status', $next_booking) }}" method="POST" class="flex-1 md:flex-none">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="skipped">
                                <input type="hidden" name="redirect_to" value="admin.dashboard">
                                <button class="w-full px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl text-sm font-medium transition-colors">Skip</button>
                            </form>
                            
                            <form action="{{ route('admin.bookings.status', $next_booking) }}" method="POST" class="flex-1 md:flex-none">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="processing">
                                <input type="hidden" name="redirect_to" value="admin.dashboard">
                                <button class="w-full px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl text-sm font-medium shadow-lg transition-all">
                                    Mulai Proses
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                
                @if($next_booking->isProcessing() && $next_booking->processing_started_at)
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const timerElement = document.getElementById('countdown');
                        const infoElement = document.getElementById('action-timer');

                        @php
                            $endTime = $next_booking->processing_started_at->copy()->addMinutes(5);
                            $remainingSeconds = now()->diffInSeconds($endTime, false);
                        @endphp
                        
                        let remaining = {{ $remainingSeconds }};
                        
                        function formatTime(t) {
                            if (t < 0) return "00:00";
                            let m = Math.floor(t / 60);
                            let s = Math.floor(t % 60);
                            return (m < 10 ? "0" + m : m) + ":" + (s < 10 ? "0" + s : s);
                        }
                        
                        timerElement.textContent = formatTime(remaining);

                        const interval = setInterval(() => {
                            remaining--;
                            
                            if (remaining <= 0) {
                                clearInterval(interval);
                                timerElement.textContent = "00:00";
                                timerElement.classList.add('text-red-600');
                                infoElement.textContent = "Waktu Habis! Silahkan selesaikan.";
                                return;
                            }
                            
                            timerElement.textContent = formatTime(remaining);
                        }, 1000);
                    });
                </script>
                @endif
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 md:p-12 text-center flex flex-col items-center justify-center">
                <div class="p-4 bg-gray-100 rounded-full mb-4">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>

                @if(isset($currentSchedule) && $currentSchedule)
                     <h3 class="text-xl font-bold text-gray-900 mb-2">Jadwal Sekarang Kosong</h3>
                     <p class="text-gray-500">
                        Sesi: {{ \Carbon\Carbon::parse($currentSchedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($currentSchedule->end_time)->format('H:i') }}<br>
                        Tidak ada antrian tersisa untuk jadwal ini.
                     </p>
                @else
                     <h3 class="text-xl font-bold text-gray-900 mb-2">Tidak Ada Jadwal Aktif</h3>
                     <p class="text-gray-500">
                        Saat ini tidak ada jadwal operasional yang aktif.<br>
                        Antrian akan muncul saat jadwal dimulai.
                     </p>
                @endif
            </div>
        @endif
    </div>

    <!-- Upcoming Queue List -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="p-4 md:p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                Antrian Mendatang
            </h3>
        </div>

        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Antrian</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pelanggan</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Layanan</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($upcoming_queue as $booking)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-mono font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-lg">{{ $booking->queue_number }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm font-medium text-gray-900">{{ $booking->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $booking->user->phone_number }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $booking->service->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $booking->time_slot }} <br>
                                <span class="text-xs">{{ $booking->schedule->event_date->format('d M') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">Tidak ada antrian lagi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards -->
        <div class="md:hidden divide-y divide-gray-100">
            @forelse($upcoming_queue as $booking)
                <div class="p-4 hover:bg-gray-50 transition">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $booking->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $booking->service->name }}</p>
                        </div>
                        <span class="font-mono font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-lg text-sm">{{ $booking->queue_number }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">{{ $booking->time_slot }} • {{ $booking->schedule->event_date->format('d M') }}</span>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-sm text-gray-500">Tidak ada antrian lagi.</div>
            @endforelse
        </div>
    </div>
@endsection