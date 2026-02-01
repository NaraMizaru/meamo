@extends('admin.layouts.app')

@section('title', 'Pemesanan')
@section('header', 'Kelola Pemesanan')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    
    <!-- Header Actions -->
    <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.bookings.create') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-4 py-2.5 rounded-xl text-sm font-bold shadow-lg transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Booking Baru
            </a>
            <a href="{{ route('admin.bookings.history') }}" class="bg-white hover:bg-gray-50 text-gray-700 px-4 py-2.5 rounded-xl text-sm font-medium border border-gray-200 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Riwayat
            </a>
        </div>

        <form method="GET" class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
            <select name="sort" onchange="this.form.submit()" class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                <option value="nearest" {{ request('sort') == 'nearest' ? 'selected' : '' }}>Terdekat</option>
                <option value="furthest" {{ request('sort') == 'furthest' ? 'selected' : '' }}>Terjauh</option>
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Baru Dibuat</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
            </select>
            <input type="text" name="search" value="{{ request('search') }}" 
                class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm w-full md:w-64 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all" 
                placeholder="Cari Nama / No. HP / Antrian...">
            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-colors">
                Cari
            </button>
        </form>
    </div>

    <!-- Desktop Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hidden md:block">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="w-10"></th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Antrian</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pelanggan</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Telepon</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Layanan</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100" id="bookingTableBody">
                @foreach($bookings as $booking)
                    <tr data-id="{{ $booking->id }}" class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-4 cursor-move text-gray-400 drag-handle">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path></svg>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-mono font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-lg">{{ $booking->queue_number }}</span>
                            <span class="text-xs text-gray-400 ml-1">#{{ $booking->sequence }}</span>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $booking->user->name }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $booking->user->phone_number }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $booking->service->name }}</td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $booking->schedule->event_date->format('d M Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $booking->time_slot }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = [
                                    'booked' => 'bg-blue-100 text-blue-800',
                                    'skipped' => 'bg-yellow-100 text-yellow-800',
                                    'processing' => 'bg-purple-100 text-purple-800 animate-pulse',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                ];
                                $statusLabels = [
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
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Lihat</a>
                                <a href="{{ route('admin.bookings.edit', $booking) }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">Edit</a>
                                <form action="{{ route('admin.bookings.move-to-top', $booking) }}" method="POST" onsubmit="return confirm('Pindahkan ke urutan teratas?');">
                                    @csrf
                                    <button class="text-green-600 hover:text-green-800 font-medium text-xs">↑ Atas</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Mobile Cards -->
    <div class="md:hidden space-y-3">
        @foreach($bookings as $booking)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4" data-id="{{ $booking->id }}">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h4 class="font-semibold text-gray-900">{{ $booking->user->name }}</h4>
                        <p class="text-sm text-gray-500">{{ $booking->user->phone_number }}</p>
                    </div>
                    <span class="font-mono font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-lg text-sm">{{ $booking->queue_number }}</span>
                </div>
                <div class="space-y-2 mb-3">
                    <p class="text-sm"><span class="text-gray-500">Layanan:</span> <span class="font-medium">{{ $booking->service->name }}</span></p>
                    <p class="text-sm"><span class="text-gray-500">Jadwal:</span> {{ $booking->schedule->event_date->format('d M Y') }} • {{ $booking->time_slot }}</p>
                </div>
                <div class="flex justify-between items-center pt-3 border-t border-gray-100">
                    @php
                        $statusColors = [
                            'booked' => 'bg-blue-100 text-blue-800',
                            'skipped' => 'bg-yellow-100 text-yellow-800',
                            'processing' => 'bg-purple-100 text-purple-800',
                            'completed' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                        ];
                        $statusLabels = ['booked' => 'Dipesan', 'skipped' => 'Dilewati', 'processing' => 'Proses', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'];
                    @endphp
                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ $statusLabels[$booking->status] ?? ucfirst($booking->status) }}
                    </span>
                    <div class="flex gap-3 text-sm">
                        <a href="{{ route('admin.bookings.show', $booking) }}" class="text-blue-600 font-medium">Lihat</a>
                        <a href="{{ route('admin.bookings.edit', $booking) }}" class="text-indigo-600 font-medium">Edit</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $bookings->links() }}
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var el = document.getElementById('bookingTableBody');
            if (el) {
                var sortable = Sortable.create(el, {
                    handle: '.drag-handle',
                    animation: 150,
                    onEnd: function (evt) {
                        var ids = [];
                        document.querySelectorAll('#bookingTableBody tr').forEach(row => {
                           ids.push(row.getAttribute('data-id')); 
                        });

                        fetch("{{ route('admin.bookings.reorder') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({ ids: ids })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (!data.success) {
                                alert(data.message || 'Gagal mengubah urutan.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan saat menyimpan urutan.');
                        });
                    }
                });
            }
        });
    </script>
@endsection