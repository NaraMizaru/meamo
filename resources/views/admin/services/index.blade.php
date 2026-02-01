@extends('admin.layouts.app')

@section('title', 'Layanan')
@section('header', 'Kelola Layanan')

@section('content')
    <!-- Header Actions -->
    <div class="mb-6">
        <a href="{{ route('admin.services.create') }}"
            class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-4 py-2.5 rounded-xl text-sm font-bold shadow-lg transition-all inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Layanan
        </a>
    </div>

    <!-- Desktop Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hidden md:block">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($services as $service)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $service->name }}</td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-gray-800">Rp
                                {{ number_format($service->price, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.services.edit', $service) }}"
                                    class="text-blue-600 hover:text-blue-800 font-medium text-sm">Edit</a>
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm"
                                        onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
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
        @foreach($services as $service)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex justify-between items-start mb-3">
                    <h4 class="font-semibold text-gray-900">{{ $service->name }}</h4>
                    <span class="font-bold text-blue-600">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                </div>
                <div class="flex gap-3 pt-3 border-t border-gray-100">
                    <a href="{{ route('admin.services.edit', $service) }}" class="text-blue-600 font-medium text-sm">Edit</a>
                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 font-medium text-sm"
                            onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $services->links() }}
    </div>
@endsection