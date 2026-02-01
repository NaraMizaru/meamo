@extends('admin.layouts.app')

@section('title', 'Tambah Jadwal')
@section('header', 'Tambah Jadwal Baru')

@section('content')
    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-4 md:p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    Jadwal Baru
                </h3>
            </div>

            <form action="{{ route('admin.schedules.store') }}" method="POST" class="p-4 md:p-6">
                @csrf

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Acara *</label>
                    <input type="date" name="event_date" value="{{ old('event_date') }}"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all @error('event_date') border-red-500 @enderror"
                        required>
                    @error('event_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Waktu Mulai *</label>
                        <input type="time" name="start_time" value="{{ old('start_time') }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all @error('start_time') border-red-500 @enderror"
                            required>
                        @error('start_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Waktu Selesai *</label>
                        <input type="time" name="end_time" value="{{ old('end_time') }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all @error('end_time') border-red-500 @enderror"
                            required>
                        @error('end_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status *</label>
                    <select name="status"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all bg-white"
                        required>
                        <option value="available">Tersedia</option>
                        <option value="booked">Dipesan</option>
                        <option value="unavailable">Tidak Tersedia</option>
                    </select>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-100">
                    <button
                        class="flex-1 sm:flex-none bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-2.5 rounded-xl font-medium shadow-lg transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan
                    </button>
                    <a href="{{ route('admin.schedules.index') }}"
                        class="flex-1 sm:flex-none bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-xl font-medium transition-colors text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection