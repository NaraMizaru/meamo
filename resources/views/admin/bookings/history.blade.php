@extends('admin.layouts.app')

@section('title', 'Riwayat Booking')
@section('header', 'Riwayat Pesanan')

@section('content')
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div
            class="p-4 md:p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-3">
                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Riwayat Pesanan
                </h3>
                <a href="{{ route('admin.bookings.index') }}"
                    class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Booking Aktif
                </a>
            </div>

            <form method="GET" class="flex gap-2 w-full md:w-auto">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm w-full md:w-64 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                    placeholder="Cari Nama / No. HP / Antrian...">
                <button type="submit"
                    class="bg-gray-800 hover:bg-gray-900 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-colors">
                    Cari
                </button>
            </form>
        </div>

        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Antrian
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pelanggan
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Layanan
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="font-mono font-bold text-gray-500 bg-gray-100 px-3 py-1 rounded-lg">{{ $booking->queue_number }}</span>
                                <br>
                                <span class="text-xs text-gray-400">{{ $booking->schedule->event_date->format('d/m/Y') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $booking->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $booking->user->phone_number }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $booking->service->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $booking->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $booking->status === 'completed' ? 'Selesai' : 'Dibatalkan' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800">
                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.bookings.show', $booking) }}"
                                    class="text-blue-600 hover:text-blue-900 font-medium">Detail</a>
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
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500">Tidak ada riwayat booking.</p>
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
                            <h4 class="font-semibold text-gray-900">{{ $booking->user->name }}</h4>
                            <p class="text-sm text-gray-500">{{ $booking->user->phone_number }}</p>
                        </div>
                        <span
                            class="font-mono font-bold text-gray-500 bg-gray-100 px-3 py-1 rounded-lg text-sm">{{ $booking->queue_number }}</span>
                    </div>
                    <div class="space-y-1 text-sm mb-3">
                        <p><span class="text-gray-500">Layanan:</span> {{ $booking->service->name }}</p>
                        <p><span class="text-gray-500">Tanggal:</span> {{ $booking->schedule->event_date->format('d M Y') }}</p>
                    </div>
                    <div class="flex justify-between items-center pt-3 border-t border-gray-100">
                        <div class="flex items-center gap-2">
                            <span
                                class="px-3 py-1 text-xs font-semibold rounded-full 
                                            {{ $booking->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $booking->status === 'completed' ? 'Selesai' : 'Dibatalkan' }}
                            </span>
                            <span class="font-bold text-gray-800">Rp
                                {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('admin.bookings.show', $booking) }}"
                            class="text-blue-600 font-medium text-sm">Detail</a>
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
                    <p class="text-gray-500">Tidak ada riwayat booking.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="px-4 md:px-6 py-4 bg-gray-50 border-t border-gray-100">
            {{ $bookings->links() }}
        </div>
    </div>
@endsection