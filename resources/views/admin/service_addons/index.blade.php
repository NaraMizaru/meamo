@extends('admin.layouts.app')

@section('title', 'Tambahan Layanan')
@section('header', 'Kelola Tambahan Layanan')

@section('content')
    <!-- Header Actions -->
    <div class="mb-6">
        <a href="{{ route('admin.service-addons.create') }}"
           class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-4 py-2.5 rounded-xl text-sm font-bold shadow-lg transition-all inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Tambahan Baru
        </a>
    </div>

    <!-- Desktop Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hidden md:block">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Hasil Item</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($addons as $addon)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $addon->name }}</div>
                            <div class="text-sm text-gray-500">{{ $addon->description }}</div>
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-800">Rp {{ number_format($addon->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach($addon->items as $item)
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">
                                        {{ $item->name }} (x{{ $item->pivot->quantity }})
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.service-addons.edit', $addon) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Edit</a>
                                <form action="{{ route('admin.service-addons.destroy', $addon) }}" method="POST" class="inline" onsubmit="return confirm('Hapus tambahan ini?');">
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
            {{ $addons->links() }}
        </div>
    </div>

    <!-- Mobile Cards -->
    <div class="md:hidden space-y-3">
        @foreach($addons as $addon)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <h4 class="font-semibold text-gray-900">{{ $addon->name }}</h4>
                        <p class="text-sm text-gray-500">{{ $addon->description }}</p>
                    </div>
                    <span class="font-bold text-blue-600 text-sm">Rp {{ number_format($addon->price, 0, ',', '.') }}</span>
                </div>
                <div class="flex flex-wrap gap-1 mb-3">
                    @foreach($addon->items as $item)
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">
                            {{ $item->name }} (x{{ $item->pivot->quantity }})
                        </span>
                    @endforeach
                </div>
                <div class="flex gap-3 pt-3 border-t border-gray-100">
                    <a href="{{ route('admin.service-addons.edit', $addon) }}" class="text-blue-600 font-medium text-sm">Edit</a>
                    <form action="{{ route('admin.service-addons.destroy', $addon) }}" method="POST" class="inline" onsubmit="return confirm('Hapus tambahan ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 font-medium text-sm">Hapus</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6 md:hidden">
        {{ $addons->links() }}
    </div>
@endsection