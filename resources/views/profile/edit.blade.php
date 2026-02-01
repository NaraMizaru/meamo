@extends('user.layouts.dashboard')

@section('title', 'Profil')
@section('header', 'Profil')

@section('content')
    <div class="space-y-6 max-w-3xl">
        <!-- Profile Information -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-4 md:p-6 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Informasi Profil
                </h3>
                <p class="text-sm text-gray-500 mt-1">Perbarui informasi profil dan alamat email akun Anda.</p>
            </div>
            <div class="p-4 md:p-6">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Password -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-4 md:p-6 border-b border-gray-100 bg-gradient-to-r from-amber-50 to-orange-50">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                        </path>
                    </svg>
                    Ubah Password
                </h3>
                <p class="text-sm text-gray-500 mt-1">Pastikan akun Anda menggunakan password yang panjang dan acak untuk
                    tetap aman.</p>
            </div>
            <div class="p-4 md:p-6">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete Account -->
        <div class="bg-white rounded-2xl shadow-lg border border-red-100 overflow-hidden">
            <div class="p-4 md:p-6 border-b border-red-100 bg-gradient-to-r from-red-50 to-pink-50">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                    Hapus Akun
                </h3>
                <p class="text-sm text-gray-500 mt-1">Hapus akun dan semua data Anda secara permanen.</p>
            </div>
            <div class="p-4 md:p-6">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection