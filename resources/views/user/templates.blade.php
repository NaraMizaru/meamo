@extends('user.layouts.app')

@section('title', 'Template')

@section('content')
    <!-- Hero Section -->
    <section
        class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white py-16 md:py-20 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-20 w-24 h-24 border-4 border-green-500 rounded-xl rotate-12"></div>
            <div class="absolute bottom-10 right-20 w-20 h-20 border-4 border-green-500 rounded-full"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-block px-4 py-2 bg-green-500/20 text-green-400 rounded-full text-sm font-medium mb-4">
                🎨 Koleksi Template
            </span>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                Template <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-green-600">Cantik</span> Kami
            </h1>
            <p class="text-lg text-gray-300 max-w-2xl mx-auto">
                Pilih dari berbagai template menarik untuk mempercantik hasil foto Anda. Tersedia berbagai tema untuk setiap
                momen spesial.
            </p>
        </div>
    </section>

    <!-- Template Gallery Section -->
    <section class="py-12 md:py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filter Section -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <span class="font-medium text-gray-700">Filter Kategori:</span>
                </div>

                <form method="GET" class="w-full md:w-auto">
                    <div class="flex flex-wrap gap-2 justify-center md:justify-end">
                        <a href="{{ route('templates') }}"
                            class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 {{ !request('category') ? 'bg-gray-900 text-white' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}">
                            Semua
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ route('templates', ['category' => $category->id]) }}"
                                class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 {{ request('category') == $category->id ? 'bg-gray-900 text-white' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </form>
            </div>

            <!-- Template Count -->
            <div class="mb-6">
                <p class="text-gray-600">
                    Menampilkan <span class="font-semibold text-gray-900">{{ $templates->count() }}</span> dari
                    <span class="font-semibold text-gray-900">{{ $templates->total() }}</span> template
                </p>
            </div>

            <!-- Template Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @forelse($templates as $template)
                    <div
                        class="group relative bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100">
                        <!-- Template Image -->
                        <div class="aspect-square overflow-hidden relative">
                            <img src="{{ asset('storage/' . $template->image) }}" alt="{{ $template->name }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">

                            <!-- Overlay on Hover -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-gray-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                                <div class="text-white">
                                    <h3 class="font-semibold text-lg">{{ $template->name }}</h3>
                                    <p class="text-sm text-gray-300">{{ $template->category?->name ?? 'Tanpa Kategori' }}</p>
                                </div>
                            </div>

                            <!-- Quick View Button -->
                            <button
                                onclick="openLightbox('{{ asset('storage/' . $template->image) }}', '{{ $template->name }}')"
                                class="absolute top-4 right-4 w-10 h-10 bg-white/90 hover:bg-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 shadow-lg">
                                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                </svg>
                            </button>
                        </div>

                        <!-- Template Info (Mobile) -->
                        <div class="p-4 md:hidden">
                            <h3 class="font-semibold text-gray-800 truncate">{{ $template->name }}</h3>
                            <p class="text-xs text-gray-500 mt-1">{{ $template->category?->name ?? 'Tanpa Kategori' }}</p>
                        </div>

                        <!-- Desktop Info -->
                        <div class="hidden md:block p-4">
                            <h3 class="font-semibold text-gray-800 truncate">{{ $template->name }}</h3>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">
                                    {{ $template->category?->name ?? 'Tanpa Kategori' }}
                                </span>
                                <button
                                    onclick="openLightbox('{{ asset('storage/' . $template->image) }}', '{{ $template->name }}')"
                                    class="text-sm text-green-600 hover:text-green-700 font-medium">
                                    Lihat
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="text-center py-16">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Template tidak ditemukan</h3>
                            <p class="text-gray-500">Coba pilih kategori lain atau lihat semua template</p>
                            <a href="{{ route('templates') }}"
                                class="inline-flex items-center mt-4 text-green-600 hover:text-green-700 font-medium">
                                Lihat Semua Template
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-10">
                {{ $templates->links() }}
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-12 md:py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-8 md:p-10 text-white">
                <h2 class="text-2xl md:text-3xl font-bold mb-3">Suka dengan Template Kami?</h2>
                <p class="text-green-100 mb-6">Pesan sekarang dan gunakan template favorit Anda untuk foto booth!</p>
                <a href="{{ route('booking.create') }}"
                    class="inline-flex items-center bg-white text-green-600 hover:bg-gray-100 px-6 py-3 rounded-xl font-semibold transition-all duration-300 hover:shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Pesan Sekarang
                </a>
            </div>
        </div>
    </section>

    <!-- Lightbox Modal -->
    <div id="lightbox" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/90 p-4"
        onclick="closeLightbox()">
        <button class="absolute top-4 right-4 text-white hover:text-green-400 transition-colors" onclick="closeLightbox()">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div class="max-w-4xl max-h-[90vh] overflow-hidden" onclick="event.stopPropagation()">
            <img id="lightbox-image" src="" alt="" class="max-w-full max-h-[80vh] object-contain rounded-lg">
            <p id="lightbox-title" class="text-white text-center mt-4 text-lg font-medium"></p>
        </div>
    </div>

    <script>
        function openLightbox(imageSrc, title) {
            document.getElementById('lightbox-image').src = imageSrc;
            document.getElementById('lightbox-title').textContent = title;
            document.getElementById('lightbox').classList.remove('hidden');
            document.getElementById('lightbox').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.add('hidden');
            document.getElementById('lightbox').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        // Close on Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeLightbox();
            }
        });
    </script>
@endsection