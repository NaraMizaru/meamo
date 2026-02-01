@extends('admin.layouts.app')

@section('title', 'Pengaturan')
@section('header', 'Pengaturan Sistem')

@section('content')
    <div class="max-w-xl">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-4 md:p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Konfigurasi Sistem
                </h3>
            </div>

            <form action="{{ route('admin.settings.store') }}" method="POST" class="p-4 md:p-6">
                @csrf

                <div class="mb-6">
                    <label class="block mb-2 font-semibold text-gray-700 text-sm">Durasi Pemesanan (Menit)</label>
                    <p class="text-sm text-gray-500 mb-3">Waktu yang dialokasikan untuk setiap slot pemesanan.</p>
                    <input type="number" name="booking_duration_minutes"
                        value="{{ $settings['booking_duration_minutes'] ?? 10 }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                        min="1" required>
                </div>

                <div class="flex justify-end">
                    <button
                        class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-2.5 rounded-xl font-medium shadow-lg transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Konfigurasi
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection