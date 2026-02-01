@extends('admin.layouts.app')

@section('title', 'Buat Promo')
@section('header', 'Tambah Promo Baru')

@section('content')
    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-4 md:p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                        </path>
                    </svg>
                    Promo Baru
                </h3>
            </div>

            <form action="{{ route('admin.promos.store') }}" method="POST" class="p-4 md:p-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Promo *</label>
                        <input type="text" name="code"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all uppercase"
                            placeholder="cth. DISKON25" required>
                        @error('code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Cakupan Layanan</label>
                        <select name="service_id"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all bg-white">
                            <option value="">-- Semua Layanan --</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Diskon *</label>
                        <select name="discount_type"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all bg-white">
                            <option value="fixed">Jumlah Tetap (Rp)</option>
                            <option value="percentage">Persentase (%)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nilai Diskon *</label>
                        <input type="number" name="discount_value"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                            min="0" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Mulai *</label>
                        <input type="date" name="start_date"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Berakhir *</label>
                        <input type="date" name="end_date"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                            required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kuota <span
                                class="font-normal text-gray-400">(Kosong = Tak Terbatas)</span></label>
                        <input type="number" name="quota"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                            min="0">
                    </div>
                    <div class="flex items-center pt-6">
                        <label
                            class="flex items-center gap-3 cursor-pointer p-3 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors w-full">
                            <input type="checkbox" name="is_auto" class="form-checkbox h-5 w-5 text-blue-600 rounded"
                                value="1">
                            <div>
                                <span class="font-semibold text-gray-800">Terapkan Otomatis</span>
                                <p class="text-xs text-gray-500">Promo diterapkan tanpa kode</p>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                        rows="2"></textarea>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-100">
                    <button
                        class="flex-1 sm:flex-none bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-2.5 rounded-xl font-medium shadow-lg transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Promo
                    </button>
                    <a href="{{ route('admin.promos.index') }}"
                        class="flex-1 sm:flex-none bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-xl font-medium transition-colors text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection