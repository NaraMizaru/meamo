<x-guest-layout>
    <!-- Register Header -->
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Buat Akun Baru 🎉</h1>
        <p class="text-gray-600">Bergabung untuk menikmati layanan photo booth kami</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nama -->
        <div class="mb-5">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                Nama Lengkap
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    autocomplete="name" placeholder="Masukkan nama lengkap"
                    class="block w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-colors" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Nomor Telepon -->
        <div class="mb-5">
            <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">
                Nomor Telepon
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </div>
                <span
                    class="absolute inset-y-0 left-10 flex items-center text-gray-500 text-sm border-r border-gray-200 pr-3">
                    +62
                </span>
                <input id="phone_number" type="text" name="phone_number" value="{{ old('phone_number') }}" required
                    autocomplete="tel" placeholder="81234567890"
                    class="block w-full pl-24 pr-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-colors" />
            </div>
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>

        <!-- Kata Sandi -->
        <div class="mb-5">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                Kata Sandi
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    placeholder="Minimal 8 karakter"
                    class="block w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-colors" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Konfirmasi Kata Sandi -->
        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                Konfirmasi Kata Sandi
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    autocomplete="new-password" placeholder="Ulangi kata sandi"
                    class="block w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-colors" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Benefits -->
        <div class="bg-green-50 rounded-xl p-4 mb-6">
            <h4 class="text-sm font-medium text-green-800 mb-3">Keuntungan menjadi member:</h4>
            <ul class="space-y-2">
                <li class="flex items-center text-sm text-green-700">
                    <svg class="w-4 h-4 mr-2 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Pemesanan mudah dan cepat
                </li>
                <li class="flex items-center text-sm text-green-700">
                    <svg class="w-4 h-4 mr-2 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Akses riwayat pemesanan
                </li>
                <li class="flex items-center text-sm text-green-700">
                    <svg class="w-4 h-4 mr-2 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Promo eksklusif
                </li>
            </ul>
        </div>

        <!-- Register Button -->
        <button type="submit"
            class="w-full bg-gradient-to-r from-gray-900 to-green-600 hover:from-gray-800 hover:to-green-500 text-white py-3.5 rounded-xl font-semibold shadow-lg shadow-green-500/20 hover:shadow-xl transition-all duration-300">
            Daftar Sekarang
        </button>

        <!-- Divider -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-gray-50 text-gray-500">atau</span>
            </div>
        </div>

        <!-- Google Register -->
        @if(Route::has('auth.google'))
            <a href="{{ route('auth.google') }}"
                class="w-full flex items-center justify-center bg-white hover:bg-gray-50 text-gray-700 py-3.5 rounded-xl font-medium border border-gray-200 transition-all duration-300">
                <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                    <path fill="#4285F4"
                        d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                    <path fill="#34A853"
                        d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                    <path fill="#FBBC05"
                        d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                    <path fill="#EA4335"
                        d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                </svg>
                Daftar dengan Google
            </a>
        @endif

        <!-- Login Link -->
        <div class="text-center mt-6 pt-6 border-t border-gray-100">
            <p class="text-sm text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}"
                    class="text-green-600 hover:text-green-700 font-semibold transition-colors ml-1">
                    Masuk di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>