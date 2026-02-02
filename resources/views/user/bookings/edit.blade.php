@extends('user.layouts.dashboard')

@section('title', 'Edit Pemesanan')
@section('header', 'Edit Booking')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left Column: Booking Form --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="p-4 md:p-6 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-blue-50">
                    <h2 class="font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Pemesanan
                    </h2>
                </div>
                <form action="{{ route('booking.update', $booking->id) }}" method="POST" id="bookingForm" class="p-4 md:p-6">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label class="block mb-2 font-semibold text-gray-700 text-sm">Layanan <span class="text-red-500">*</span></label>
                        <select id="service_select" name="service_id" 
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all bg-white" 
                            required onchange="updateForm()">
                            <option value="">-- Pilih Layanan --</option>
                            @foreach($services as $service)
                                @php
                                    $yieldData = $service->items->map(function ($item) {
                                        return ['name' => $item->name, 'quantity' => $item->pivot->quantity];
                                    });
                                @endphp
                                <option value="{{ $service->id }}" data-price="{{ $service->price }}"
                                    data-addons="{{ $service->addons->pluck('id') }}"
                                    data-yield='{{ json_encode($yieldData) }}'
                                    {{ $booking->service_id == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }} (Rp {{ number_format($service->price, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Addons Section -->
                    <div id="addons_section" class="mb-6 hidden">
                        <label class="block mb-3 font-semibold text-gray-700 text-sm">Tambahan</label>
                        <div class="space-y-3">
                            @foreach($services->pluck('addons')->flatten()->unique('id') as $addon)
                                @php
                                    $addonYield = $addon->items->map(function ($item) {
                                        return ['name' => $item->name, 'quantity' => $item->pivot->quantity];
                                    });
                                    $existingAddon = $booking->addons->find($addon->id);
                                    $existingQty = $existingAddon ? $existingAddon->pivot->quantity : 0;
                                @endphp
                                <div class="addon-item border border-gray-200 rounded-xl p-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 hover:border-blue-200 hover:bg-blue-50/30 transition-colors"
                                    data-id="{{ $addon->id }}" data-yield='{{ json_encode($addonYield) }}'>
                                    <div class="flex-1">
                                        <span class="font-medium text-gray-800">{{ $addon->name }}</span>
                                        <p class="text-sm text-gray-500">{{ $addon->description }}</p>
                                    </div>
                                    <div class="flex items-center justify-between sm:justify-end gap-4">
                                        <span class="text-blue-600 font-bold text-sm">Rp {{ number_format($addon->price, 0, ',', '.') }}</span>
                                        <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                                            <button type="button" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 transition-colors"
                                                onclick="updateQty(this, -1)">−</button>
                                            <input type="number" name="addons[{{ $addon->id }}]" value="{{ $existingQty }}" min="0"
                                                class="w-12 text-center border-none p-2 focus:ring-0 addon-qty bg-white"
                                                data-price="{{ $addon->price }}" data-name="{{ $addon->name }}" readonly>
                                            <button type="button" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 transition-colors"
                                                onclick="updateQty(this, 1)">+</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 font-semibold text-gray-700 text-sm">Jadwal <span class="text-red-500">*</span></label>
                        <select id="schedule_select" name="schedule_id" 
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all bg-white" 
                            required onchange="checkPromo()">
                            <option value="">-- Pilih Tanggal --</option>
                            @foreach($schedules as $schedule)
                                @php 
                                    $isBookingSchedule = $booking->schedule_id == $schedule->id;
                                    $isAvailable = $schedule->isAvailable() || $isBookingSchedule; 
                                @endphp
                                <option value="{{ $schedule->id }}" data-date="{{ $schedule->event_date->format('Y-m-d') }}" {{ !$isAvailable ? 'disabled' : '' }}
                                    class="{{ !$isAvailable ? 'text-gray-400 bg-gray-100' : '' }}"
                                    {{ $isBookingSchedule ? 'selected' : '' }}>
                                    {{ $schedule->event_date->format('d F Y') }} ({{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }})
                                    {{ !$isAvailable ? '(Penuh)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 font-semibold text-gray-700 text-sm">Kode Promo</label>
                        <div class="flex gap-2">
                            <input type="text" id="promo_code" name="promo_code"
                                class="flex-1 border border-gray-200 rounded-xl px-4 py-3 uppercase focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all" 
                                placeholder="Masukkan kode" onchange="checkPromo()" value="{{ $booking->promo ? $booking->promo->code : '' }}">
                            <button type="button" onclick="checkPromo('manual')"
                                class="bg-gray-100 hover:bg-gray-200 px-5 rounded-xl font-medium transition-colors text-gray-700">Terapkan</button>
                        </div>
                        <p id="promo_message" class="text-sm mt-2"></p>
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 font-semibold text-gray-700 text-sm">Catatan</label>
                        <textarea name="notes" rows="3"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all resize-none"
                            placeholder="Catatan opsional...">{{ old('notes', $booking->notes) }}</textarea>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <button class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white py-3.5 rounded-xl font-bold shadow-lg shadow-blue-500/25 transition-all duration-200 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('dashboard') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-3.5 rounded-xl font-bold text-center transition-colors flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Right Column: Order Summary --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden lg:sticky lg:top-24">
                <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-blue-50">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        Ringkasan Pesanan
                    </h3>
                </div>
                <div class="p-4 md:p-6">
                    <div id="summary_items" class="space-y-2 mb-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Layanan</span>
                            <span class="font-medium text-gray-800" id="summary_service">-</span>
                        </div>
                        <div id="summary_addons_list" class="space-y-1 pl-3 border-l-2 border-blue-100 mt-2">
                            <!-- Addons inserted here -->
                        </div>
                    </div>

                    <!-- Yield Summary -->
                    <div class="bg-gradient-to-r from-indigo-50 to-blue-50 p-4 rounded-xl mb-4">
                        <h4 class="font-semibold text-gray-700 mb-2 text-sm flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Total Item (Hasil):
                        </h4>
                        <ul id="yield_summary_list" class="list-disc list-inside text-gray-600 space-y-1 text-sm">
                            <li>-</li>
                        </ul>
                    </div>

                    <div class="border-t pt-4 space-y-2">
                        <div class="flex justify-between text-gray-600 text-sm">
                            <span>Subtotal</span>
                            <span id="summary_subtotal">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-green-600 font-medium text-sm" id="summary_discount_row"
                            style="display:none;">
                            <span>Diskon <span id="promo_name_display" class="text-xs text-gray-500"></span></span>
                            <span id="summary_discount">- Rp 0</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold text-gray-800 mt-3 pt-3 border-t-2 border-dashed">
                            <span>Total</span>
                            <span id="summary_total" class="text-blue-600">Rp 0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        // State
        let currentPromo = @json($booking->promo);
        let initialLoad = true;

        function updateQty(btn, change) {
            const input = btn.parentNode.querySelector('input');
            let val = parseInt(input.value) || 0;
            val = Math.max(0, val + change);
            input.value = val;
            calculateTotal();
        }

        function updateForm() {
            const serviceSelect = document.getElementById('service_select');
            const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
            const addonsSection = document.getElementById('addons_section');
            const addonItems = document.querySelectorAll('.addon-item');

            if (!selectedOption.value) {
                addonsSection.classList.add('hidden');
                checkPromo();
                calculateTotal();
                return;
            }

            const validAddons = JSON.parse(selectedOption.getAttribute('data-addons') || '[]');

            let hasAddons = false;
            addonItems.forEach(item => {
                const id = parseInt(item.getAttribute('data-id'));
                const input = item.querySelector('input');

                if (validAddons.includes(id)) {
                    item.classList.remove('hidden');
                    hasAddons = true;
                } else {
                    item.classList.add('hidden');
                    if (!initialLoad) {
                         input.value = 0; 
                    }
                }
            });

            if (hasAddons) {
                addonsSection.classList.remove('hidden');
            } else {
                addonsSection.classList.add('hidden');
            }

            if (!initialLoad) {
                checkPromo(); 
            }
            calculateTotal();
        }

        function calculateTotal() {
            const serviceSelect = document.getElementById('service_select');
            const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];

            const summaryService = document.getElementById('summary_service');
            const summaryAddonsList = document.getElementById('summary_addons_list');
            const summarySubtotal = document.getElementById('summary_subtotal');
            const summaryTotal = document.getElementById('summary_total');
            const summaryDiscountRow = document.getElementById('summary_discount_row');
            const summaryDiscount = document.getElementById('summary_discount');
            const yieldSummaryList = document.getElementById('yield_summary_list');

            let subtotal = 0;
            summaryAddonsList.innerHTML = '';
            let totalYield = {};

            if (selectedOption.value) {
                let price = parseFloat(selectedOption.getAttribute('data-price'));
                subtotal += price;
                summaryService.textContent = `${selectedOption.text.split('(')[0]} (Rp ${price.toLocaleString('id-ID')})`;

                let serviceYield = JSON.parse(selectedOption.getAttribute('data-yield') || '[]');
                serviceYield.forEach(item => {
                    totalYield[item.name] = (totalYield[item.name] || 0) + item.quantity;
                });

            } else {
                summaryService.textContent = '-';
            }

            const addonInputs = document.querySelectorAll('.addon-qty');
            addonInputs.forEach(input => {
                let qty = parseInt(input.value) || 0;
                if (qty > 0) {
                    let price = parseFloat(input.getAttribute('data-price'));
                    let totalAddonPrice = price * qty;
                    subtotal += totalAddonPrice;

                    let div = document.createElement('div');
                    div.className = 'flex justify-between text-xs text-gray-500';
                    div.innerHTML = `<span>+ ${input.getAttribute('data-name')} x${qty}</span><span>Rp ${totalAddonPrice.toLocaleString('id-ID')}</span>`;
                    summaryAddonsList.appendChild(div);

                    let addonItemDiv = input.closest('.addon-item');
                    let addonYield = JSON.parse(addonItemDiv.getAttribute('data-yield') || '[]');
                    addonYield.forEach(item => {
                        totalYield[item.name] = (totalYield[item.name] || 0) + (item.quantity * qty);
                    });
                }
            });

            yieldSummaryList.innerHTML = '';
            let hasYield = false;
            for (const [name, qty] of Object.entries(totalYield)) {
                let li = document.createElement('li');
                li.textContent = `${qty}x ${name}`;
                yieldSummaryList.appendChild(li);
                hasYield = true;
            }
            if (!hasYield) yieldSummaryList.innerHTML = '<li>-</li>';


            summarySubtotal.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');

            let discountAmount = 0;
            if (currentPromo) {
                if (currentPromo.discount_amount) {
                    discountAmount = parseFloat(currentPromo.discount_amount);
                } else if (currentPromo.discount_percentage) {
                    discountAmount = subtotal * (parseFloat(currentPromo.discount_percentage) / 100);
                }
                discountAmount = Math.min(discountAmount, subtotal);
            }

            if (discountAmount > 0) {
                summaryDiscountRow.style.display = 'flex';
                summaryDiscount.textContent = '- Rp ' + discountAmount.toLocaleString('id-ID');
                document.getElementById('promo_name_display').textContent = `(${currentPromo.code})`;
            } else {
                summaryDiscountRow.style.display = 'none';
                document.getElementById('promo_name_display').textContent = '';
            }

            let total = subtotal - discountAmount;
            summaryTotal.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        async function checkPromo(mode = 'auto') {
            const promoCodeInput = document.getElementById('promo_code');
            const serviceSelect = document.getElementById('service_select');
            const scheduleSelect = document.getElementById('schedule_select');
            const messageEl = document.getElementById('promo_message');

            const serviceId = serviceSelect.value;
            const scheduleId = scheduleSelect.value;
            const manualCode = promoCodeInput.value.trim();

            messageEl.textContent = '';

            if (!serviceId || !scheduleId) {
                currentPromo = null;
                calculateTotal();
                return;
            }

            const scheduleDate = scheduleSelect.options[scheduleSelect.selectedIndex].getAttribute('data-date');

            try {
                const response = await fetch('{{ route("api.check-promo") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        service_id: serviceId,
                        date: scheduleDate,
                        code: manualCode
                    })
                });

                const data = await response.json();

                if (data.valid && data.promo) {
                    currentPromo = data.promo;
                    if (mode === 'manual') {
                        messageEl.className = 'text-green-600 text-sm mt-2 flex items-center gap-1';
                        messageEl.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Promo Diterapkan: ' + data.promo.code;
                        promoCodeInput.value = data.promo.code;
                    } else {
                        if (manualCode === '') {
                            promoCodeInput.value = data.promo.code;
                            messageEl.textContent = ''; 
                        }
                    }
                } else {
                    currentPromo = null;
                    if (mode === 'manual' && manualCode !== '') {
                        messageEl.className = 'text-red-600 text-sm mt-2 flex items-center gap-1';
                        messageEl.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> Kode Promo tidak valid untuk tanggal/layanan yang dipilih.';
                    } else if (mode === 'auto' && manualCode !== '') {
                        promoCodeInput.value = '';
                    }
                }

                calculateTotal();

            } catch (error) {
                console.error('Error Pemeriksaan Promo', error);
                messageEl.className = 'text-red-600 text-sm mt-2';
                messageEl.textContent = 'Terjadi kesalahan saat memeriksa promo.';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateForm();
            initialLoad = false;
        });
    </script>
@endsection
