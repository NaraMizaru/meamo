@extends('admin.layouts.app')

@section('title', 'Promo')
@section('header', 'Kelola Promo')

@section('content')
    <!-- Header Actions -->
    <div class="mb-6">
        <a href="{{ route('admin.promos.create') }}" 
           class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-4 py-2.5 rounded-xl text-sm font-bold shadow-lg transition-all inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Promo Baru
        </a>
    </div>

    <!-- Desktop Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hidden md:block">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kode</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Diskon</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Masa Berlaku</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Penggunaan</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tipe</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($promos as $promo)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-mono font-bold text-purple-600 bg-purple-50 px-3 py-1 rounded-lg">{{ $promo->code }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-gray-800">
                                @if($promo->discount_type == 'percentage')
                                    {{ $promo->discount_amount }}%
                                @else
                                    Rp {{ number_format($promo->discount_amount, 0, ',', '.') }}
                                @endif
                            </span>
                            <div class="text-xs text-gray-500">{{ $promo->service ? $promo->service->name : 'Semua Layanan' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $promo->start_date->format('d M') }} - {{ $promo->end_date->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 font-medium">
                            {{ $promo->used_count }} / {{ $promo->quota ?? '∞' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $promo->is_auto ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $promo->is_auto ? 'Otomatis' : 'Manual' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.promos.edit', $promo) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Edit</a>
                                <form action="{{ route('admin.promos.destroy', $promo) }}" method="POST" class="inline" onsubmit="return confirm('Hapus promo ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            {{ $promos->links() }}
        </div>
    </div>

    <!-- Mobile Cards -->
    <div class="md:hidden space-y-3">
        @foreach($promos as $promo)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex justify-between items-start mb-3">
                    <span class="font-mono font-bold text-purple-600 bg-purple-50 px-3 py-1 rounded-lg">{{ $promo->code }}</span>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $promo->is_auto ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $promo->is_auto ? 'Otomatis' : 'Manual' }}
                    </span>
                </div>
                <div class="space-y-1 text-sm mb-3">
                    <p><span class="text-gray-500">Diskon:</span> 
                        <span class="font-semibold">
                            @if($promo->discount_type == 'percentage')
                                {{ $promo->discount_amount }}%
                            @else
                                Rp {{ number_format($promo->discount_amount, 0, ',', '.') }}
                            @endif
                        </span>
                    </p>
                    <p><span class="text-gray-500">Berlaku:</span> {{ $promo->start_date->format('d M') }} - {{ $promo->end_date->format('d M Y') }}</p>
                    <p><span class="text-gray-500">Penggunaan:</span> {{ $promo->used_count }} / {{ $promo->quota ?? '∞' }}</p>
                    <p><span class="text-gray-500">Layanan:</span> {{ $promo->service ? $promo->service->name : 'Semua' }}</p>
                </div>
                <div class="flex gap-3 pt-3 border-t border-gray-100">
                    <a href="{{ route('admin.promos.edit', $promo) }}" class="text-blue-600 font-medium text-sm">Edit</a>
                    <form action="{{ route('admin.promos.destroy', $promo) }}" method="POST" class="inline" onsubmit="return confirm('Hapus promo ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 font-medium text-sm">Hapus</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6 md:hidden">
        {{ $promos->links() }}
    </div>
@endsection