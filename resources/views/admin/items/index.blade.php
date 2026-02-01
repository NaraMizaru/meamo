@extends('admin.layouts.app')

@section('title', 'Item')
@section('header', 'Kelola Item')

@section('content')
    <!-- Header Actions -->
    <div class="mb-6">
        <a href="{{ route('admin.items.create') }}"
            class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-4 py-2.5 rounded-xl text-sm font-bold shadow-lg transition-all inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Item Baru
        </a>
    </div>

    <!-- Desktop Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hidden md:block">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($items as $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-gray-500 font-mono text-sm">{{ $item->id }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $item->name }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.items.edit', $item) }}"
                                    class="text-blue-600 hover:text-blue-800 font-medium text-sm">Edit</a>
                                <form action="{{ route('admin.items.destroy', $item) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Hapus item ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-800 font-medium text-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            {{ $items->links() }}
        </div>
    </div>

    <!-- Mobile Cards -->
    <div class="md:hidden space-y-3">
        @foreach($items as $item)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex justify-between items-start mb-3">
                    <h4 class="font-semibold text-gray-900">{{ $item->name }}</h4>
                    <span class="text-xs text-gray-400 font-mono">ID: {{ $item->id }}</span>
                </div>
                <div class="flex gap-3 pt-3 border-t border-gray-100">
                    <a href="{{ route('admin.items.edit', $item) }}" class="text-blue-600 font-medium text-sm">Edit</a>
                    <form action="{{ route('admin.items.destroy', $item) }}" method="POST" class="inline"
                        onsubmit="return confirm('Hapus item ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 font-medium text-sm">Hapus</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6 md:hidden">
        {{ $items->links() }}
    </div>
@endsection