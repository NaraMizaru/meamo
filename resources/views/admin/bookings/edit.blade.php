@extends('admin.layouts.app')

@section('title', 'Edit Booking')
@section('header', 'Edit Booking #' . $booking->queue_number)

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Kolom Kiri: Form Pemesanan --}}
        <div class="lg:col-span-2">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                <form action="{{ route('admin.bookings.update', $booking) }}" method="POST" id="bookingForm">
                    @csrf
                    @method('PUT')

                    <!-- Informasi Pelanggan (Read Only) -->
                    <div class="mb-6 border-b pb-4">
                        <h4 class="font-bold text-gray-700 mb-4 uppercase text-sm tracking-wider">Informasi Pelanggan</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-2 font-semibold">Nama Pelanggan</label>
                                <input type="text" class="w-full border rounded-lg px-4 py-3 bg-gray-100 text-gray-500" value="{{ $booking->user->name }}" readonly>
                            </div>
                            <div>
                                <label class="block mb-2 font-semibold">Nomor Telepon</label>
                                <input type="text" class="w-full border rounded-lg px-4 py-3 bg-gray-100 text-gray-500" value="{{ $booking->user->phone_number }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 font-semibold">Layanan *</label>
                        <select id="service_select" name="service_id" class="w-full border rounded-lg px-4 py-3" required
                            onchange="updateForm()">
                            <option value="">-- Pilih Layanan --</option>
                            @foreach($services as $service)
                                @php
                                    $yieldData = $service->items->map(function ($item) {
                                        return ['name' => $item->name, 'quantity' => $item->pivot->quantity];
                                    });
                                @endphp
                                <option value="{{ $service->id }}" 
                                    {{ $booking->service_id == $service->id ? 'selected' : '' }}
                                    data-price="{{ $service->price }}"
                                    data-addons="{{ $service->addons->pluck('id') }}"
                                    data-yield='{{ json_encode($yieldData) }}'>
                                    {{ $service->name }} (Rp {{ number_format($service->price, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Bagian Addon -->
                    <div id="addons_section" class="mb-6 hidden">
                        <label class="block mb-2 font-semibold">Tambahan</label>
                        <div class="grid grid-cols-1 gap-4">
                            @foreach($services->pluck('addons')->flatten()->unique('id') as $addon)
                                @php
                                    $addonYield = $addon->items->map(function ($item) {
                                        return ['name' => $item->name, 'quantity' => $item->pivot->quantity];
                                    });
                                    // Check if existing booking has this addon
                                    $existingPivot = $booking->addons->find($addon->id)?->pivot;
                                    $currentQty = $existingPivot ? $existingPivot->quantity : 0;
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
                                            <input type="number" name="addons[{{ $addon->id }}]" value="{{ $currentQty }}" min="0"
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
                        <label class="block mb-2 font-semibold">Jadwal *</label>
                        <select id="schedule_select" name="schedule_id" class="w-full border rounded-lg px-4 py-3" required>
                            <option value="">-- Pilih Tanggal --</option>
                            @foreach($schedules as $schedule)
                                @php $isAvailable = $schedule->isAvailable() || $schedule->id == $booking->schedule_id; @endphp
                                <option value="{{ $schedule->id }}" 
                                    {{ $booking->schedule_id == $schedule->id ? 'selected' : '' }}
                                    data-date="{{ $schedule->event_date->format('Y-m-d') }}" {{ !$isAvailable ? 'disabled' : '' }}
                                    class="{{ !$isAvailable ? 'text-gray-400 bg-gray-100' : '' }}">
                                    {{ $schedule->event_date->format('d F Y') }} ({{ $schedule->next_slot }})
                                    {{ !$isAvailable ? '(Penuh)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 font-semibold">Catatan</label>
                        <textarea name="notes" class="w-full border rounded-lg px-4 py-3">{{ $booking->notes }}</textarea>
                    </div>

                    <div class="flex gap-4">
                        <a href="{{ route('admin.bookings.show', $booking) }}" class="flex-1 bg-gray-200 text-gray-700 py-3 rounded-lg font-bold hover:bg-gray-300 text-center">
                            Batal
                        </a>
                        <button class="flex-1 bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Kolom Kanan: Ringkasan Pesanan --}}
        <div class="lg:col-span-1">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 sticky top-6">
                <h3 class="text-lg font-bold mb-4 border-b pb-2">Estimasi Ringkasan</h3>

                <div id="summary_items" class="space-y-2 mb-4 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Layanan</span>
                        <span class="font-medium" id="summary_service">-</span>
                    </div>
                    <div id="summary_addons_list" class="space-y-1 pl-2 border-l-2 border-gray-100 mt-2">
                        <!-- Addon dimasukkan di sini -->
                    </div>
                </div>

                <!-- Bagian Ringkasan Hasil -->
                <div class="bg-gray-50 p-3 rounded mb-4 text-sm">
                    <h4 class="font-semibold text-gray-700 mb-2">Total Item (Hasil):</h4>
                    <ul id="yield_summary_list" class="list-disc list-inside text-gray-600 space-y-1">
                        <li>-</li>
                    </ul>
                </div>

                <div class="border-t pt-2 space-y-2">
                     <div class="bg-yellow-50 text-yellow-800 text-xs p-2 rounded border border-yellow-200 mb-2">
                        Perhatian: Mengedit pesanan akan mereset promo jika ada dan menghitung ulang total harga.
                    </div>
                    <div class="flex justify-between text-xl font-bold text-gray-800 mt-2 pt-2 border-t">
                        <span>Estimasi Total</span>
                        <span id="summary_total">Rp 0</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        // Simplified Logic from Create Page (Removed Promo Logic)
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
                calculateTotal();
                return;
            }

            const validAddons = JSON.parse(selectedOption.getAttribute('data-addons') || '[]');
            
            // Only unhide allowed addons, keep values if they were set (via PHP loop)
            let hasAddons = false;
            addonItems.forEach(item => {
                const id = parseInt(item.getAttribute('data-id'));
                if (validAddons.includes(id)) {
                    item.classList.remove('hidden');
                    hasAddons = true;
                } else {
                    item.classList.add('hidden');
                     // Don't reset value here automatically to allow preserve across service change? 
                     // Usually if service changes, addon compatibility changes. Resetting unsafe values is better.
                     const input = item.querySelector('input');
                     input.value = 0;
                }
            });

            if (hasAddons) {
                addonsSection.classList.remove('hidden');
            } else {
                addonsSection.classList.add('hidden');
            }

            calculateTotal();
        }

        function calculateTotal() {
            const serviceSelect = document.getElementById('service_select');
            const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];

            const summaryService = document.getElementById('summary_service');
            const summaryAddonsList = document.getElementById('summary_addons_list');
            const summaryTotal = document.getElementById('summary_total');
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
                // Check if visible (closest addon-item not hidden)
                if (qty > 0 && !input.closest('.addon-item').classList.contains('hidden')) {
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

            summaryTotal.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateForm();
        });
    </script>
@endsection
