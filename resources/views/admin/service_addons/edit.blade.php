@extends('admin.layouts.app')

@section('title', 'Edit Tambahan')
@section('header', 'Edit Tambahan Layanan')

@section('content')
    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-4 md:p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    Edit Tambahan
                </h3>
            </div>

            <form action="{{ route('admin.service-addons.update', $serviceAddon) }}" method="POST" class="p-4 md:p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Tambahan *</label>
                        <input type="text" name="name" value="{{ old('name', $serviceAddon->name) }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                            required>
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Harga (Rp) *</label>
                        <input type="number" name="price" value="{{ old('price', $serviceAddon->price) }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                            min="0" required>
                        @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                        rows="2">{{ old('description', $serviceAddon->description) }}</textarea>
                </div>

                <div class="mb-6 pt-4 border-t border-gray-100">
                    <label class="block text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Hasil Item (Output)
                    </label>
                    <p class="text-sm text-gray-500 mb-3">Pilih item mana yang diberikan tambahan ini kepada pelanggan.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        @foreach($items as $index => $item)
                                            @php
                                                $relatedItem = $serviceAddon->items->find($item->id);
                                                $isChecked = $relatedItem ? true : false;
                                                $quantity = $relatedItem ? $relatedItem->pivot->quantity : 1;
                                            @endphp
                             <div
                                                class="border border-gray-200 rounded-xl p-3 flex items-center justify-between hover:bg-gray-50 transition-colors">
                                                <div class="flex items-center gap-3">
                                                    <input type="checkbox" name="items[{{ $index }}][id]" value="{{ $item->id }}"
                                                        class="form-checkbox h-5 w-5 text-blue-600 rounded item-checkbox"
                                                        onchange="toggleQuantity(this, {{ $index }})" {{ $isChecked ? 'checked' : '' }}>
                                                    <span class="font-medium text-gray-800">{{ $item->name }}</span>
                                                </div>
                                                <input type="number" name="items[{{ $index }}][quantity]" id="qty_{{ $index }}"
                                                    class="w-16 border border-gray-200 rounded-lg px-2 py-1 text-center focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                                                    value="{{ $quantity }}" min="1" {{ $isChecked ? '' : 'disabled' }}>
                                            </div>
                        @endforeach
                    </div>
                </div>

                <script>
                    function toggleQuantity(checkbox, index) {
                        const qtyInput = document.getElementById('qty_' + index);
                        qtyInput.disabled = !checkbox.checked;
                    }
                </script>

                <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-100">
                    <button
                        class="flex-1 sm:flex-none bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-2.5 rounded-xl font-medium shadow-lg transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Perbarui Tambahan
                    </button>
                    <a href="{{ route('admin.service-addons.index') }}"
                        class="flex-1 sm:flex-none bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-xl font-medium transition-colors text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection