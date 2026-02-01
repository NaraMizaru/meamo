@extends('admin.layouts.app')

@section('title', 'Jadwal')
@section('header', 'Kelola Jadwal')

@section('content')
    <!-- Header Actions -->
    <div class="mb-6">
        <a href="{{ route('admin.schedules.create') }}"
           class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-4 py-2.5 rounded-xl text-sm font-bold shadow-lg transition-all inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Jadwal
        </a>
    </div>

    <!-- Desktop Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hidden md:block">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Waktu</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($schedules as $schedule)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $schedule->event_date->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-gray-500">
                        {{ $schedule->start_time }} - {{ $schedule->end_time }}
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $statusColors = [
                                'available' => 'bg-green-100 text-green-800',
                                'booked' => 'bg-blue-100 text-blue-800',
                                'unavailable' => 'bg-gray-100 text-gray-800',
                            ];
                            $statusLabels = [
                                'available' => 'Tersedia',
                                'booked' => 'Dipesan',
                                'unavailable' => 'Tidak Tersedia',
                            ];
                        @endphp
                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$schedule->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $statusLabels[$schedule->status] ?? ucfirst($schedule->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.schedules.edit', $schedule) }}"
                               class="text-blue-600 hover:text-blue-800 font-medium text-sm">Edit</a>
                            <form action="{{ route('admin.schedules.destroy', $schedule) }}"
                                  method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:text-red-800 font-medium text-sm"
                                        onclick="return confirm('Apakah Anda yakin?')">
                                    Hapus
                                </button>
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
        @foreach($schedules as $schedule)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h4 class="font-semibold text-gray-900">{{ $schedule->event_date->format('d M Y') }}</h4>
                        <p class="text-sm text-gray-500">{{ $schedule->start_time }} - {{ $schedule->end_time }}</p>
                    </div>
                    @php
                        $statusColors = [
                            'available' => 'bg-green-100 text-green-800',
                            'booked' => 'bg-blue-100 text-blue-800',
                            'unavailable' => 'bg-gray-100 text-gray-800',
                        ];
                        $statusLabels = ['available' => 'Tersedia', 'booked' => 'Dipesan', 'unavailable' => 'Tidak Tersedia'];
                    @endphp
                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$schedule->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ $statusLabels[$schedule->status] ?? ucfirst($schedule->status) }}
                    </span>
                </div>
                <div class="flex gap-3 pt-3 border-t border-gray-100">
                    <a href="{{ route('admin.schedules.edit', $schedule) }}" class="text-blue-600 font-medium text-sm">Edit</a>
                    <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 font-medium text-sm" onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $schedules->links() }}
    </div>
@endsection
