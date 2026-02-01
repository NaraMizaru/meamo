@extends('admin.layouts.app')

@section('title', 'Booking Detail')
@section('header', 'Booking Detail')

@section('content')
    <div class="bg-white rounded-lg shadow p-6 max-w-4xl">

        <div class="flex justify-between items-start mb-6">
            <div>
                <h3 class="text-xl font-bold">Booking #{{ $booking->id }}</h3>
                <span class="text-gray-500">Created: {{ $booking->created_at->format('d M Y H:i') }}</span>
            </div>
            <div class="text-right">
                <div class="text-3xl font-bold">{{ $booking->queue_number }}</div>
                <div class="text-sm text-gray-500">Sequence #{{ $booking->sequence }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-lg font-semibold mb-3 border-b pb-2">Customer Info</h3>
                <p class="mb-1"><span class="font-medium">Name:</span> {{ $booking->user->name }}</p>
                <p class="mb-1"><span class="font-medium">Phone:</span> {{ $booking->user->phone_number ?? '-' }}</p>
                @if($booking->notes)
                    <div class="mt-2 bg-yellow-50 p-2 rounded text-sm">
                        <span class="font-medium">Notes:</span> {{ $booking->notes }}
                    </div>
                @endif
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-3 border-b pb-2">Schedule Info</h3>
                <p class="mb-1"><span class="font-medium">Date:</span> {{ $booking->schedule->event_date->format('d F Y') }}
                </p>
                <p class="mb-1"><span class="font-medium">Est. Slot:</span> {{ $booking->time_slot }}</p>
                <p class="mb-1"><span class="font-medium">Status:</span>
                    <span
                        class="px-2 py-1 text-xs rounded-full 
                            {{ $booking->status === 'completed' ? 'bg-green-100 text-green-800' :
        ($booking->status === 'skipped' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </p>
            </div>
        </div>

        <div class="mt-8">
            <h3 class="text-lg font-semibold mb-3 border-b pb-2">Order Summary</h3>

            <div class="bg-gray-50 rounded p-4">
                <div class="flex justify-between mb-2">
                    <span>Base Service: <b>{{ $booking->service->name }}</b></span>
                    <span>Rp {{ number_format($booking->service->price, 0, ',', '.') }}</span>
                </div>

                @foreach($booking->addons as $addon)
                    <div class="flex justify-between mb-2 text-sm text-gray-700">
                        <span>+ Addon: {{ $addon->name }}</span>
                        <span>Rp {{ number_format($addon->price, 0, ',', '.') }}</span>
                    </div>
                @endforeach

                @if($booking->promo)
                    <div class="flex justify-between mb-2 text-green-600">
                        <span>Promo: {{ $booking->promo->code ?? $booking->promo->description }}</span>
                        <span>- Rp {{ number_format($booking->promo->discount_amount ?? 0, 0, ',', '.') }}</span>
                    </div>
                @endif

                <div class="border-t mt-3 pt-3 flex justify-between font-bold text-lg">
                    <span>Total Price</span>
                    <span>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <h3 class="text-lg font-semibold mb-3 border-b pb-2">Items Yield (Output)</h3>
            <ul class="list-disc list-inside">
                @foreach($booking->items as $item)
                    <li>{{ $item->name }} <span
                            class="badge bg-blue-100 text-blue-800 px-2 rounded-full text-xs">x{{ $item->pivot->quantity }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <hr class="my-6">

        <div class="flex gap-4 items-center flex-wrap">
            <form action="{{ route('admin.bookings.status', $booking) }}" method="POST" class="flex gap-2 items-center">
                @csrf
                @method('PATCH')
                <select name="status" class="border px-3 py-2 rounded">
                    @foreach(['pending', 'booked', 'skipped', 'completed', 'cancelled'] as $status)
                        <option value="{{ $status }}" {{ $booking->status === $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Update Status
                </button>
            </form>

            @if($booking->status === 'skipped')
                <form action="{{ route('admin.bookings.move-to-top', $booking) }}" method="POST">
                    @csrf
                    <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-bold">
                        Arrow Up Move to Top
                    </button>
                </form>
            @endif

            @if($booking->status === 'completed')
                <form action="{{ route('admin.bookings.send-result', $booking) }}" method="POST">
                    @csrf
                    <button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">
                        Send Photos
                    </button>
                </form>
            @endif

            <a href="{{ route('admin.bookings.index') }}" class="ml-auto text-gray-600 hover:underline">
                &larr; Back to List
            </a>
        </div>
    </div>
@endsection