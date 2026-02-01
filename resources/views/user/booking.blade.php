@extends('user.layouts.dashboard')

@section('title', 'Book Now')
@section('header', 'New Booking')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left Column: Booking Form --}}
        <div class="lg:col-span-2">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
                    @csrf

                    <div class="mb-6">
                        <label class="block mb-2 font-semibold">Service *</label>
                        <select id="service_select" name="service_id" class="w-full border rounded-lg px-4 py-3" required
                            onchange="updateForm()">
                            <option value="">-- Select Service --</option>
                            @foreach($services as $service)
                                {{-- Prepare Item Yield Data --}}
                                @php
                                    $yieldData = $service->items->map(function ($item) {
                                        return ['name' => $item->name, 'quantity' => $item->pivot->quantity];
                                    });
                                @endphp
                                <option value="{{ $service->id }}" data-price="{{ $service->price }}"
                                    data-addons="{{ $service->addons->pluck('id') }}"
                                    data-yield='{{ json_encode($yieldData) }}'>
                                    {{ $service->name }} (Rp {{ number_format($service->price, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Addons Section -->
                    <div id="addons_section" class="mb-6 hidden">
                        <label class="block mb-2 font-semibold">Add-ons</label>
                        <div class="grid grid-cols-1 gap-4">
                            @foreach($services->pluck('addons')->flatten()->unique('id') as $addon)
                                @php
                                    $addonYield = $addon->items->map(function ($item) {
                                        return ['name' => $item->name, 'quantity' => $item->pivot->quantity];
                                    });
                                @endphp
                                <div class="addon-item border rounded p-3 flex justify-between items-center"
                                    data-id="{{ $addon->id }}" data-yield='{{ json_encode($addonYield) }}'>
                                    <div class="flex items-center gap-3 flex-1">
                                        <div class="flex flex-col">
                                            <span class="font-medium">{{ $addon->name }}</span>
                                            <span class="text-sm text-gray-500">{{ $addon->description }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <span class="text-blue-600 font-semibold text-sm">Rp
                                            {{ number_format($addon->price, 0, ',', '.') }}</span>
                                        <div class="flex items-center border rounded">
                                            <button type="button" class="px-3 py-1 bg-gray-100 hover:bg-gray-200"
                                                onclick="updateQty(this, -1)">-</button>
                                            <input type="number" name="addons[{{ $addon->id }}]" value="0" min="0"
                                                class="w-12 text-center border-none p-1 focus:ring-0 addon-qty"
                                                data-price="{{ $addon->price }}" data-name="{{ $addon->name }}" readonly>
                                            <button type="button" class="px-3 py-1 bg-gray-100 hover:bg-gray-200"
                                                onclick="updateQty(this, 1)">+</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 font-semibold">Schedule *</label>
                        <select id="schedule_select" name="schedule_id" class="w-full border rounded-lg px-4 py-3" required
                            onchange="checkPromo()">
                            <option value="">-- Select Date --</option>
                            @foreach($schedules as $schedule)
                                @php $isAvailable = $schedule->isAvailable(); @endphp
                                <option value="{{ $schedule->id }}" data-date="{{ $schedule->event_date->format('Y-m-d') }}" {{ !$isAvailable ? 'disabled' : '' }}
                                    class="{{ !$isAvailable ? 'text-gray-400 bg-gray-100' : '' }}">
                                    {{ $schedule->event_date->format('d F Y') }} ({{ $schedule->next_slot }})
                                    {{ !$isAvailable ? '(Full)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 font-semibold">Promo Code</label>
                        <div class="flex gap-2">
                            <input type="text" id="promo_code" name="promo_code"
                                class="w-full border rounded-lg px-4 py-3 uppercase" placeholder="Enter code"
                                onchange="checkPromo()">
                            <button type="button" onclick="checkPromo('manual')"
                                class="bg-gray-200 px-4 rounded hover:bg-gray-300">Apply</button>
                        </div>
                        <p id="promo_message" class="text-sm mt-1"></p>
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 font-semibold">Notes</label>
                        <textarea name="notes" class="w-full border rounded-lg px-4 py-3"
                            placeholder="Optional notes..."></textarea>
                    </div>

                    <button class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700">
                        Submit Booking
                    </button>
                </form>
            </div>
        </div>

        {{-- Right Column: Order Summary --}}
        <div class="lg:col-span-1">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 sticky top-6">
                <h3 class="text-lg font-bold mb-4 border-b pb-2">Order Summary</h3>

                <div id="summary_items" class="space-y-2 mb-4 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Service</span>
                        <span class="font-medium" id="summary_service">-</span>
                    </div>
                    <div id="summary_addons_list" class="space-y-1 pl-2 border-l-2 border-gray-100 mt-2">
                        <!-- Addons injected here -->
                    </div>
                </div>

                <!-- Yield Summary Section -->
                <div class="bg-gray-50 p-3 rounded mb-4 text-sm">
                    <h4 class="font-semibold text-gray-700 mb-2">Total Items (Yield):</h4>
                    <ul id="yield_summary_list" class="list-disc list-inside text-gray-600 space-y-1">
                        <li>-</li>
                    </ul>
                </div>

                <div class="border-t pt-2 space-y-2">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span id="summary_subtotal">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-green-600 font-medium" id="summary_discount_row"
                        style="display:none;">
                        <span>Discount <span id="promo_name_display" class="text-xs text-gray-500"></span></span>
                        <span id="summary_discount">- Rp 0</span>
                    </div>
                    <div class="flex justify-between text-xl font-bold text-gray-800 mt-2 pt-2 border-t">
                        <span>Total</span>
                        <span id="summary_total">Rp 0</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        // State
        let currentPromo = null;

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
                checkPromo(); // Check promo again as service Changed
                calculateTotal();
                return;
            }

            // Show relevant addons
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
                    input.value = 0; // Reset hidden addons
                }
            });

            if (hasAddons) {
                addonsSection.classList.remove('hidden');
            } else {
                addonsSection.classList.add('hidden');
            }

            checkPromo(); // Check promo again as service Changed
            calculateTotal();
        }

        function calculateTotal() {
            const serviceSelect = document.getElementById('service_select');
            const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];

            // Summary Elements
            const summaryService = document.getElementById('summary_service');
            const summaryAddonsList = document.getElementById('summary_addons_list');
            const summarySubtotal = document.getElementById('summary_subtotal');
            const summaryTotal = document.getElementById('summary_total');
            const summaryDiscountRow = document.getElementById('summary_discount_row');
            const summaryDiscount = document.getElementById('summary_discount');
            const yieldSummaryList = document.getElementById('yield_summary_list');

            let subtotal = 0;
            summaryAddonsList.innerHTML = ''; // Clear list
            let totalYield = {};

            // Base Service
            if (selectedOption.value) {
                let price = parseFloat(selectedOption.getAttribute('data-price'));
                subtotal += price;
                summaryService.textContent = `${selectedOption.text.split('(')[0]} (Rp ${price.toLocaleString('id-ID')})`;

                // Service Yield
                let serviceYield = JSON.parse(selectedOption.getAttribute('data-yield') || '[]');
                serviceYield.forEach(item => {
                    totalYield[item.name] = (totalYield[item.name] || 0) + item.quantity;
                });

            } else {
                summaryService.textContent = '-';
            }

            // Addons
            const addonInputs = document.querySelectorAll('.addon-qty');
            addonInputs.forEach(input => {
                let qty = parseInt(input.value) || 0;
                if (qty > 0) {
                    let price = parseFloat(input.getAttribute('data-price'));
                    let totalAddonPrice = price * qty;
                    subtotal += totalAddonPrice;

                    // Add to summary
                    let div = document.createElement('div');
                    div.className = 'flex justify-between text-xs text-gray-500';
                    div.innerHTML = `<span>+ ${input.getAttribute('data-name')} x${qty}</span><span>Rp ${totalAddonPrice.toLocaleString('id-ID')}</span>`;
                    summaryAddonsList.appendChild(div);

                    // Addon Yield
                    let addonItemDiv = input.closest('.addon-item');
                    let addonYield = JSON.parse(addonItemDiv.getAttribute('data-yield') || '[]');
                    addonYield.forEach(item => {
                        totalYield[item.name] = (totalYield[item.name] || 0) + (item.quantity * qty);
                    });
                }
            });

            // Update Yield Display
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

            // Discount
            let discountAmount = 0;
            if (currentPromo) {
                if (currentPromo.discount_amount) {
                    discountAmount = parseFloat(currentPromo.discount_amount);
                } else if (currentPromo.discount_percentage) {
                    discountAmount = subtotal * (parseFloat(currentPromo.discount_percentage) / 100);
                }
                // Cap at subtotal
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

            // Clear previous message
            messageEl.textContent = '';

            // Clear current promo if inputs missing, unless checking manual code only
            if (!serviceId || !scheduleId) {
                currentPromo = null;
                calculateTotal();
                return;
            }

            const scheduleDate = scheduleSelect.options[scheduleSelect.selectedIndex].getAttribute('data-date');

            // Logic:
            // 1. If manual code entered, validate that code specificially.
            // 2. If NO manual code, check for AUTO promos.

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
                        messageEl.className = 'text-green-600 text-sm mt-1';
                        messageEl.textContent = 'Promo Applied: ' + data.promo.code;
                        promoCodeInput.value = data.promo.code; // Fill in auto code if found
                    } else {
                        // Auto mode: Only notify if we found something and user didn't type anything
                        if (manualCode === '') {
                            promoCodeInput.value = data.promo.code;
                            messageEl.textContent = ''; // Don't spam success message for auto
                        }
                    }
                } else {
                    currentPromo = null;
                    if (mode === 'manual' && manualCode !== '') {
                        messageEl.className = 'text-red-600 text-sm mt-1';
                        messageEl.textContent = 'Invalid Promo Code for selected date/service.';
                    } else if (mode === 'auto' && manualCode !== '') {
                        // If there's a manual code but it's not valid for auto, clear it.
                        // This prevents an invalid manual code from persisting if user changes service/date.
                        promoCodeInput.value = '';
                    }
                }

                calculateTotal();

            } catch (error) {
                console.error('Promo Check Error', error);
                messageEl.className = 'text-red-600 text-sm mt-1';
                messageEl.textContent = 'An error occurred while checking promo.';
            }
        }

        // Initial calls
        document.addEventListener('DOMContentLoaded', () => {
            updateForm(); // This will also call calculateTotal and checkPromo
        });
    </script>
@endsection