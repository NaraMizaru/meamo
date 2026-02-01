@extends('admin.layouts.app')

@section('title', 'Edit Promo')
@section('header', 'Edit Promo')

@section('content')
    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-4 md:p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    Edit Promo
                </h3>
            </div>

            <form action="{{ route('admin.promos.update', $promo) }}" method="POST" class="p-4 md:p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Promo *</label>
                        <input type="text" name="code" value="{{ old('code', $promo->code) }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all uppercase"
                            required>
                        @error('code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Cakupan Layanan</label>
                        <select name="service_id"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all bg-white">
                            <option value="">-- Semua Layanan --</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ $promo->service_id == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Diskon *</label>
                        <select name="discount_type"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all bg-white">
                            <option value="fixed" {{ $promo->discount_amount ? 'selected' : '' }}>Jumlah Tetap (Rp)</option>
                            <option value="percentage" {{ $promo->discount_percentage ? 'selected' : '' }}>Persentase (%)
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nilai Diskon *</label>
                        <input type="number" name="discount_value"
                            value="{{ $promo->discount_amount ?? $promo->discount_percentage }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                            min="0" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Mulai *</label>
                        <input type="date" name="start_date"
                            value="{{ old('start_date', $promo->start_date->format('Y-m-d')) }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Berakhir *</label>
                        <input type="date" name="end_date" value="{{ old('end_date', $promo->end_date->format('Y-m-d')) }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                            required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kuota <span
                                class="font-normal text-gray-400">(Kosong = Tak Terbatas)</span></label>
                        <input type="number" name="quota" value="{{ old('quota', $promo->quota) }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                            min="0">
                    </div>
                    <div class="flex items-center pt-6">
                        <label
                            class="flex items-center gap-3 cursor-pointer p-3 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors w-full">
                            <input type="checkbox" name="is_auto" class="form-checkbox h-5 w-5 text-blue-600 rounded"
                                value="1" {{ $promo->is_auto ? 'checked' : '' }}>
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
                        rows="2">{{ old('description', $promo->description) }}</textarea>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-100">
                    <button
                        class="flex-1 sm:flex-none bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-2.5 rounded-xl font-medium shadow-lg transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Perbarui Promo
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