@extends('admin.layouts.app')

@section('title', 'Edit Promo')
@section('header', 'Edit Promo')

@section('content')
    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <form action="{{ route('admin.promos.update', $promo) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block mb-2 font-semibold">Promo Code *</label>
                    <input type="text" name="code" value="{{ old('code', $promo->code) }}"
                        class="w-full border rounded px-3 py-2 uppercase" required>
                    @error('code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block mb-2 font-semibold">Service Scope</label>
                    <select name="service_id" class="w-full border rounded px-3 py-2">
                        <option value="">-- Apply to All Services --</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ $promo->service_id == $service->id ? 'selected' : '' }}>
                                {{ $service->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block mb-2 font-semibold">Discount Type *</label>
                    <select name="discount_type" class="w-full border rounded px-3 py-2">
                        <option value="fixed" {{ $promo->discount_amount ? 'selected' : '' }}>Fixed Amount (Rp)</option>
                        <option value="percentage" {{ $promo->discount_percentage ? 'selected' : '' }}>Percentage (%)</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-2 font-semibold">Discount Value *</label>
                    <input type="number" name="discount_value" 
                        value="{{ $promo->discount_amount ?? $promo->discount_percentage }}" 
                        class="w-full border rounded px-3 py-2" min="0" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block mb-2 font-semibold">Start Date *</label>
                    <input type="date" name="start_date"
                        value="{{ old('start_date', $promo->start_date->format('Y-m-d')) }}"
                        class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block mb-2 font-semibold">End Date *</label>
                    <input type="date" name="end_date" value="{{ old('end_date', $promo->end_date->format('Y-m-d')) }}"
                        class="w-full border rounded px-3 py-2" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block mb-2 font-semibold">Quota (Empty for Unlimited)</label>
                    <input type="number" name="quota" value="{{ old('quota', $promo->quota) }}"
                        class="w-full border rounded px-3 py-2" min="0">
                </div>
                <div class="flex items-center mt-8">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="is_auto" class="form-checkbox h-5 w-5 text-blue-600" value="1" {{ $promo->is_auto ? 'checked' : '' }}>
                        <span class="font-semibold">Auto Apply?</span>
                    </label>
                    <p class="text-xs text-gray-500 ml-4">If checked, this promo applies automatically.</p>
                </div>
            </div>

            <div class="mb-6">
                <label class="block mb-2 font-semibold">Description</label>
                <textarea name="description" class="w-full border rounded px-3 py-2"
                    rows="2">{{ old('description', $promo->description) }}</textarea>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.promos.index') }}" class="px-4 py-2 bg-gray-200 rounded">Cancel</a>
                <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update Promo</button>
            </div>
        </form>
    </div>
@endsection