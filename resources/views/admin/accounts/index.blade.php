@extends('admin.layouts.app')

@section('title', 'Kelola Akun')
@section('header', 'Kelola Akun Admin & User')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <form action="{{ route('admin.accounts.index') }}" method="GET" class="flex gap-2 w-full max-w-lg">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."
                class="w-full rounded-lg border-gray-300">
            <select name="role" class="rounded-lg border-gray-300">
                <option value="">Semua Role</option>
                <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="admin_web" {{ request('role') == 'admin_web' ? 'selected' : '' }}>Admin Web</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Cari</button>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Nama</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Role</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.accounts.update', $user) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="name" value="{{ $user->name }}">
                                <input type="hidden" name="email" value="{{ $user->email }}">
                                <select name="role" onchange="this.form.submit()"
                                    class="text-sm rounded-lg border-gray-200 py-1 px-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="admin_web" {{ $user->role == 'admin_web' ? 'selected' : '' }}>Admin Web
                                    </option>
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.accounts.destroy', $user) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm"
                                        onclick="return confirm('Hapus akun ini?')">Hapus</button>
                                </form>
                            @else
                                <span class="text-gray-400 text-sm">Akun Saya</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">Tidak ada pengguna ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $users->links() }}
        </div>
    </div>
@endsection