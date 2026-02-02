@extends('admin.layouts.app')

@section('title', 'Riwayat Keuangan')
@section('header', 'Riwayat Perubahan Keuangan')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Waktu</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">User</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Aksi</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Detail Perubahan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($histories as $h)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $h->created_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $h->user->name ?? 'Sistem' }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-bold 
                                            {{ $h->action == 'created' ? 'bg-green-100 text-green-700' :
                    ($h->action == 'updated' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                    {{ ucfirst($h->action) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                @if(is_array($h->changes))
                                    <ul class="list-disc list-inside">
                                        @foreach($h->changes as $change)
                                            <li>{{ $change }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    {{ $h->changes }}
                                @endif
                            </td>
                        </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada riwayat perubahan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $histories->links() }}
        </div>
    </div>
@endsection