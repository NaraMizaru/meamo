<x-guest-layout>
    <!-- Login Header -->
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Selamat Datang Kembali 👋</h1>
        <p class="text-gray-600">Masuk ke akun Anda untuk melanjutkan</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

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
                    autofocus autocomplete="tel" placeholder="81234567890"
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
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    placeholder="Masukkan kata sandi"
                    class="block w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-colors" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mb-6">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember"
                    class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500 transition-colors">
                <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-green-600 hover:text-green-700 font-medium transition-colors"
                    href="{{ route('password.request') }}">
                    Lupa kata sandi?
                </a>
            @endif
        </div>

        <!-- Login Button -->
        <button type="submit"
            class="w-full bg-gradient-to-r from-gray-900 to-green-600 hover:from-gray-800 hover:to-green-500 text-white py-3.5 rounded-xl font-semibold shadow-lg shadow-green-500/20 hover:shadow-xl transition-all duration-300">
            Masuk
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

        <!-- Google Login -->
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
                Masuk dengan Google
            </a>
        @endif

        <!-- Check Queue -->
        <div class="text-center mt-6">
            <a href="{{ route('check-queue') }}" class="text-sm text-gray-600 hover:text-green-600 transition-colors">
                <span class="inline-flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Cek status antrian
                </span>
            </a>
        </div>

        <!-- Register Link -->
        <div class="text-center mt-6 pt-6 border-t border-gray-100">
            <p class="text-sm text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}"
                    class="text-green-600 hover:text-green-700 font-semibold transition-colors ml-1">
                    Daftar sekarang
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>