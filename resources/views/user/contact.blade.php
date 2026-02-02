@extends('user.layouts.app')

@section('title', 'Kontak')

@section('content')
    <!-- Hero Section -->
    <section
        class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white py-16 md:py-20 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 right-20 w-24 h-24 border-4 border-green-500 rounded-xl rotate-12"></div>
            <div class="absolute bottom-10 left-20 w-28 h-28 border-4 border-green-500 rounded-full"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-block px-4 py-2 bg-green-500/20 text-green-400 rounded-full text-sm font-medium mb-4">
                💬 Hubungi Kami
            </span>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                Ada <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-green-600">Pertanyaan?</span>
            </h1>
            <p class="text-lg text-gray-300 max-w-2xl mx-auto">
                Tim kami siap membantu Anda. Hubungi kami melalui berbagai channel yang tersedia.
            </p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-12 md:py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-8 md:gap-12">
                <!-- Contact Info -->
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">Informasi Kontak</h2>
                    <p class="text-gray-600 mb-8">
                        Jangan ragu untuk menghubungi kami. Tim kami akan dengan senang hati membantu menjawab pertanyaan
                        dan memberikan informasi yang Anda butuhkan.
                    </p>

                    <!-- Contact Cards -->
                    <div class="space-y-4">
                        <!-- WhatsApp -->
                        <a href="https://wa.me/6283173043030" target="_blank"
                            class="flex items-center p-4 bg-white rounded-2xl shadow-sm border border-gray-100 hover:border-green-200 hover:shadow-lg transition-all duration-300 group">
                            <div
                                class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-green-500 transition-colors">
                                <svg class="w-7 h-7 text-green-600 group-hover:text-white transition-colors"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm text-gray-500">WhatsApp</div>
                                <div class="font-semibold text-gray-900">+62 831-7304-3030</div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 ml-auto group-hover:text-green-500 transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <!-- Phone -->
                        <a href="tel:+6281234567890"
                            class="flex items-center p-4 bg-white rounded-2xl shadow-sm border border-gray-100 hover:border-green-200 hover:shadow-lg transition-all duration-300 group">
                            <div
                                class="w-14 h-14 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-green-500 transition-colors">
                                <svg class="w-7 h-7 text-gray-600 group-hover:text-white transition-colors" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm text-gray-500">Telepon</div>
                                <div class="font-semibold text-gray-900">+62 831-7304-3030</div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 ml-auto group-hover:text-green-500 transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <!-- Email -->
                        <a href="mailto:info@meamo.com"
                            class="flex items-center p-4 bg-white rounded-2xl shadow-sm border border-gray-100 hover:border-green-200 hover:shadow-lg transition-all duration-300 group">
                            <div
                                class="w-14 h-14 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-green-500 transition-colors">
                                <svg class="w-7 h-7 text-gray-600 group-hover:text-white transition-colors" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm text-gray-500">Email</div>
                                <div class="font-semibold text-gray-900">info@meamo.com</div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 ml-auto group-hover:text-green-500 transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <!-- Location -->
                        <div class="flex items-start p-4 bg-white rounded-2xl shadow-sm border border-gray-100">
                            <div class="w-14 h-14 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-7 h-7 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm text-gray-500">Lokasi</div>
                                <div class="font-semibold text-gray-900">Lobby SMKN 2 Sukabumi</div>
                                <div class="text-sm text-gray-600">Sukabumi, Jawa Barat, Indonesia 43141</div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="mt-8">
                        <h3 class="font-semibold text-gray-900 mb-4">Ikuti Kami</h3>
                        <div class="flex space-x-3">
                            <a href="#"
                                class="w-12 h-12 bg-white hover:bg-green-500 rounded-xl flex items-center justify-center text-gray-600 hover:text-white shadow-sm border border-gray-100 transition-all duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="w-12 h-12 bg-white hover:bg-green-500 rounded-xl flex items-center justify-center text-gray-600 hover:text-white shadow-sm border border-gray-100 transition-all duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="w-12 h-12 bg-white hover:bg-green-500 rounded-xl flex items-center justify-center text-gray-600 hover:text-white shadow-sm border border-gray-100 transition-all duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Kirim Pesan</h2>

                    <form id="contactForm" class="space-y-5">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" id="name" name="name" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-colors"
                                placeholder="Masukkan nama Anda">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-colors"
                                placeholder="email@contoh.com">
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                            <div class="flex">
                                <span
                                    class="inline-flex items-center px-4 rounded-l-xl border border-r-0 border-gray-200 bg-gray-50 text-gray-500 text-sm">
                                    +62
                                </span>
                                <input type="text" id="phone" name="phone"
                                    class="w-full px-4 py-3 rounded-r-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-colors"
                                    placeholder="81234567890">
                            </div>
                        </div>

                        <!-- Subject -->
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subjek</label>
                            <select id="subject" name="subject" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-colors">
                                <option value="">Pilih subjek</option>
                                <option value="booking">Pemesanan Photo Booth</option>
                                <option value="pricing">Informasi Harga</option>
                                <option value="custom">Custom Template</option>
                                <option value="partnership">Kerjasama</option>
                                <option value="other">Lainnya</option>
                            </select>
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Pesan</label>
                            <textarea id="message" name="message" rows="4" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-colors resize-none"
                                placeholder="Tulis pesan Anda..."></textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-gray-900 to-green-600 hover:from-gray-800 hover:to-green-500 text-white py-3.5 rounded-xl font-semibold shadow-lg shadow-green-500/20 hover:shadow-xl transition-all duration-300">
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section (Placeholder) -->
    <section class="py-12 md:py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Lokasi Kami</h2>
                <p class="text-gray-600">Kunjungi photo booth kami di lobby SMKN 2 Sukabumi</p>
            </div>

            <!-- Map Placeholder -->
            <div class="bg-gray-200 rounded-2xl h-80 flex items-center justify-center relative overflow-hidden">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.628797913694!2d106.92588219999999!3d-6.934891899999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6848182063ba19%3A0xcc6bd9bbe54d5cb7!2sSMKN%202%20Sukabumi!5e0!3m2!1sid!2sid!4v1770045982017!5m2!1sid!2sid"
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('contactForm');
            if (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const name = document.getElementById('name').value;
                    const email = document.getElementById('email').value;
                    const phone = document.getElementById('phone').value;
                    const subjectElement = document.getElementById('subject');
                    const subject = subjectElement.options[subjectElement.selectedIndex].text;
                    const message = document.getElementById('message').value;

                    const text = `Halo Meamo Photo Booth, saya ingin bertanya:

    *Nama*: ${name}
    *Email*: ${email}
    *No. HP*: ${phone}
    *Subjek*: ${subject}

    *Pesan*:
    ${message}`;

                    const phoneNumber = '6283173043030';
                    const encodedText = encodeURIComponent(text);
                    const url = `https://wa.me/${phoneNumber}?text=${encodedText}`;

                    window.open(url, '_blank');
                });
            }
        });
    </script>
@endsection