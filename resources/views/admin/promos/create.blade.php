@extends('admin.layouts.app')

@section('title', 'Create Promo')
@section('header', 'Add New Promo')

@section('content')
    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <form action="{{ route('admin.promos.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block mb-2 font-semibold">Promo Code *</label>
                    <input type="text" name="code" class="w-full border rounded px-3 py-2 uppercase"
                        placeholder="e.g. SUMMER25" required>
                    @error('code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block mb-2 font-semibold">Service Scope</label>
                    <select name="service_id" class="w-full border rounded px-3 py-2">
                        <option value="">-- Apply to All Services --</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block mb-2 font-semibold">Discount Type *</label>
                    <select name="discount_type" class="w-full border rounded px-3 py-2">
                        <option value="fixed">Fixed Amount (Rp)</option>
                        <option value="percentage">Percentage (%)</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-2 font-semibold">Discount Value *</label>
                    <input type="number" name="discount_value" class="w-full border rounded px-3 py-2" min="0" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block mb-2 font-semibold">Start Date *</label>
                    <input type="date" name="start_date" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block mb-2 font-semibold">End Date *</label>
                    <input type="date" name="end_date" class="w-full border rounded px-3 py-2" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block mb-2 font-semibold">Quota (Empty for Unlimited)</label>
                    <input type="number" name="quota" class="w-full border rounded px-3 py-2" min="0">
                </div>
                <div class="flex items-center mt-8">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="is_auto" class="form-checkbox h-5 w-5 text-blue-600" value="1">
                        <span class="font-semibold">Auto Apply?</span>
                    </label>
                    <p class="text-xs text-gray-500 ml-4">If checked, this promo applies automatically without entering
                        code.</p>
                </div>
            </div>

            <div class="mb-6">
                <label class="block mb-2 font-semibold">Description</label>
                <textarea name="description" class="w-full border rounded px-3 py-2" rows="2"></textarea>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.promos.index') }}" class="px-4 py-2 bg-gray-200 rounded">Cancel</a>
                <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save Promo</button>
            </div>
        </form>
    </div>
@endsection