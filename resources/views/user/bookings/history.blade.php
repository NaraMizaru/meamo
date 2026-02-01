@extends('user.layouts.dashboard')

@section('title', 'Riwayat Booking')
@section('header', 'Riwayat Pesanan')

@section('content')
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Tabs -->
        <div class="border-b border-gray-100">
            <nav class="flex" aria-label="Tabs">
                <a href="{{ route('bookings.index') }}"
                    class="flex-1 sm:flex-none text-center sm:text-left px-6 py-4 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm transition-colors">
                    <span class="flex items-center justify-center sm:justify-start gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        Booking Aktif
                    </span>
                </a>
                <a href="{{ route('bookings.history') }}"
                    class="flex-1 sm:flex-none text-center sm:text-left px-6 py-4 border-b-2 border-blue-500 text-blue-600 font-semibold text-sm bg-blue-50/50 transition-colors">
                    <span class="flex items-center justify-center sm:justify-start gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Riwayat Pesanan
                    </span>
                </a>
            </nav>
        </div>

        <!-- Header -->
        <div class="p-4 md:p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Riwayat Pesanan (Selesai / Dibatalkan)
            </h3>
        </div>

        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Layanan
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Jadwal</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Antrian
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $booking->service->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $booking->schedule->event_date->format('d M Y') }} <br>
                                <span class="text-xs text-gray-400">{{ $booking->time_slot }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="font-mono font-bold text-gray-500 bg-gray-100 px-3 py-1 rounded-lg">{{ $booking->queue_number }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'completed' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                    ];
                                    $color = $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800">
                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500">Belum ada riwayat pesanan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards -->
        <div class="md:hidden divide-y divide-gray-100">
            @forelse($bookings as $booking)
                <div class="p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ $booking->service->name }}</h4>
                            <p class="text-sm text-gray-500">{{ $booking->schedule->event_date->format('d M Y') }} •
                                {{ $booking->time_slot }}</p>
                        </div>
                        <span
                            class="font-mono font-bold text-gray-500 bg-gray-100 px-3 py-1 rounded-lg text-sm">{{ $booking->queue_number }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        @php
                            $statusColors = [
                                'completed' => 'bg-green-100 text-green-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                            ];
                            $color = $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $color }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                        <span class="font-bold text-gray-800">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-500">Belum ada riwayat pesanan.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="px-4 md:px-6 py-4 bg-gray-50 border-t border-gray-100">
            {{ $bookings->links() }}
        </div>
    </div>
@endsection