@extends('user.layouts.dashboard')

@section('title', 'Daftar Booking')
@section('header', 'Booking Aktif')

@section('content')
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Tabs -->
        <div class="border-b border-gray-100">
            <nav class="flex" aria-label="Tabs">
                <a href="{{ route('bookings.index') }}"
                    class="flex-1 sm:flex-none text-center sm:text-left px-6 py-4 border-b-2 border-blue-500 text-blue-600 font-semibold text-sm bg-blue-50/50 transition-colors">
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
                    class="flex-1 sm:flex-none text-center sm:text-left px-6 py-4 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium text-sm transition-colors">
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
        <div
            class="p-4 md:p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 bg-gradient-to-r from-gray-50 to-white">
            <h3 class="text-lg font-bold text-gray-800">Daftar Reservasi Anda</h3>
            <div class="flex gap-2">
                <form method="GET" class="flex gap-2">
                    <select name="sort"
                        class="border border-gray-200 rounded-xl px-4 py-2 text-sm bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                        onchange="this.form.submit()">
                        <option value="nearest" {{ request('sort') == 'nearest' ? 'selected' : '' }}>Terdekat</option>
                        <option value="furthest" {{ request('sort') == 'furthest' ? 'selected' : '' }}>Terjauh</option>
                    </select>
                </form>
            </div>
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
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
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
                                    class="font-mono font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-lg">{{ $booking->queue_number }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'booked' => 'bg-blue-100 text-blue-800',
                                        'skipped' => 'bg-yellow-100 text-yellow-800',
                                        'in_progress' => 'bg-purple-100 text-purple-800',
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if(in_array($booking->status, ['booked', 'skipped']))
                                    <a href="{{ route('booking.edit', $booking->id) }}"
                                        class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-900 font-semibold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                        Edit
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                            </path>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500">Tidak ada booking aktif.</p>
                                    <a href="{{ route('booking.create') }}"
                                        class="mt-4 text-blue-600 hover:text-blue-800 font-semibold">+ Buat Pemesanan Baru</a>
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
                            class="font-mono font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-lg text-sm">{{ $booking->queue_number }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-3">
                        @php
                            $statusColors = [
                                'booked' => 'bg-blue-100 text-blue-800',
                                'skipped' => 'bg-yellow-100 text-yellow-800',
                                'in_progress' => 'bg-purple-100 text-purple-800',
                            ];
                            $color = $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $color }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                        <span class="font-bold text-gray-800">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </div>
                    @if(in_array($booking->status, ['booked', 'skipped']))
                        <a href="{{ route('booking.edit', $booking->id) }}"
                            class="w-full flex items-center justify-center gap-2 bg-indigo-50 text-indigo-600 py-2 rounded-lg font-semibold text-sm hover:bg-indigo-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                            Edit Booking
                        </a>
                    @endif
                </div>
            @empty
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </div>
                    <p class="text-gray-500 mb-4">Tidak ada booking aktif.</p>
                    <a href="{{ route('booking.create') }}" class="text-blue-600 hover:text-blue-800 font-semibold">+ Buat
                        Pemesanan Baru</a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="px-4 md:px-6 py-4 bg-gray-50 border-t border-gray-100">
            {{ $bookings->links() }}
        </div>
    </div>
@endsection