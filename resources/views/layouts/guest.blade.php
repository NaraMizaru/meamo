<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Meamo Photo Booth') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .auth-bg {
            background: linear-gradient(135deg, #1a1a1a 0%, #0f0f0f 100%);
        }

        .auth-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2322c55e' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex">
        <!-- Left Side - Branding (Hidden on mobile) -->
        <div class="hidden lg:flex lg:w-1/2 auth-bg auth-pattern relative overflow-hidden">
            <!-- Decorative Elements -->
            <div class="absolute top-20 left-10 w-32 h-32 border-4 border-green-500/20 rounded-full"></div>
            <div class="absolute top-40 right-20 w-24 h-24 border-4 border-green-500/20 rounded-xl rotate-45"></div>
            <div class="absolute bottom-32 left-1/4 w-20 h-20 border-4 border-green-500/20 rounded-full"></div>
            <div class="absolute bottom-20 right-1/3 w-16 h-16 border-4 border-green-500/20 rounded-xl rotate-12"></div>

            <div class="flex flex-col items-center justify-center w-full p-12 relative z-10">
                <!-- Logo -->
                <a href="/" class="flex items-center space-x-3 mb-8">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg shadow-green-500/30">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <span class="text-3xl font-bold text-white">Meamo</span>
                </a>

                <!-- Main Illustration -->
                <div class="w-72 h-72 mb-8 relative">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-green-500/20 to-green-600/20 rounded-3xl rotate-6">
                    </div>
                    <div
                        class="absolute inset-4 bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl flex items-center justify-center border border-green-500/30">
                        <div class="text-center p-8">
                            <div
                                class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-lg shadow-green-500/30">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <p class="text-gray-400 text-sm">Photo Booth Profesional</p>
                        </div>
                    </div>

                    <!-- Floating Badge -->
                    <div
                        class="absolute -top-2 -right-2 w-16 h-16 bg-green-500 rounded-xl flex items-center justify-center text-white font-bold shadow-lg shadow-green-500/30">
                        HD
                    </div>
                </div>

                <!-- Tagline -->
                <h2 class="text-3xl font-bold text-white text-center mb-4">
                    Abadikan Momen <span class="text-green-400">Berharga</span>
                </h2>
                <p class="text-gray-400 text-center max-w-sm">
                    Layanan photo booth profesional dengan kualitas terbaik untuk setiap momen spesial Anda.
                </p>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="w-full lg:w-1/2 flex flex-col min-h-screen bg-gray-50">
            <!-- Mobile Header -->
            <div class="lg:hidden bg-gradient-to-r from-gray-900 to-gray-800 px-6 py-8 text-center">
                <a href="/" class="inline-flex items-center space-x-2 mb-2">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <span class="text-2xl font-bold text-white">Meamo</span>
                </a>
                <p class="text-gray-400 text-sm">Photo Booth Profesional</p>
            </div>

            <!-- Form Container -->
            <div class="flex-1 flex items-center justify-center p-6 sm:p-8 lg:p-12">
                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center py-6 text-sm text-gray-500">
                &copy; {{ date('Y') }} Meamo Photo Booth. Seluruh hak cipta dilindungi.
            </div>
        </div>
    </div>
</body>

</html>