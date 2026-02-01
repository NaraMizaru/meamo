@extends('user.layouts.app')

@section('title', 'Cek Antrian')

@section('content')
    <div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    Data Antrian
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Silakan masukkan ID Antrian atau Nomor HP Anda
                </p>
            </div>

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if(isset($booking))
                {{-- Result Display --}}
                <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                    <div class="px-4 py-5 sm:px-6 bg-blue-600 text-white">
                        <h3 class="text-lg leading-6 font-medium">Antrian Ditemukan</h3>
                        <p class="mt-1 max-w-2xl text-sm text-blue-100">Detail pemesanan Anda.</p>
                    </div>
                    <div class="border-t border-gray-200">
                        <dl>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Nomor Antrian</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 font-bold">
                                    {{ $booking->queue_number }}
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Nama</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $booking->user->name }}</dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Layanan</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $booking->service->name }}</dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Jadwal</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $booking->schedule->event_date->format('d M Y') }} <br>
                                    <span class="text-gray-500">{{ $booking->time_slot }}</span>
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1 sm:mt-0 sm:col-span-2">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $booking->status === 'completed' ? 'bg-green-100 text-green-800' :
                ($booking->status === 'processing' ? 'bg-blue-100 text-blue-800 animate-pulse' :
                    ($booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </dd>
                            </div>

                            {{-- Items Section --}}
                            @if($booking->items->count() > 0)
                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Item Didapat</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <ul class="list-disc pl-5">
                                            @foreach($booking->items as $item)
                                                <li>{{ $item->pivot->quantity }}x {{ $item->name }}</li>
                                            @endforeach
                                        </ul>
                                    </dd>
                                </div>
                            @endif

                            {{-- Notes --}}
                            @if($booking->notes)
                                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Catatan</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 italic">
                                        "{{ $booking->notes }}"
                                    </dd>
                                </div>
                            @endif

                        </dl>
                    </div>

                    {{-- Price Section --}}
                    <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                        <h4 class="text-sm font-bold text-gray-900 mb-4">Rincian Biaya</h4>
                        <div class="space-y-2 text-sm text-gray-700">
                            <div class="flex justify-between">
                                <span>{{ $booking->service->name }}</span>
                                <span>Rp {{ number_format($booking->service->price, 0, ',', '.') }}</span>
                            </div>
                            @foreach($booking->addons as $addon)
                                <div class="flex justify-between">
                                    <span>+ {{ $addon->name }} (x{{ $addon->pivot->quantity }})</span>
                                    <span>Rp {{ number_format($addon->pivot->price * $addon->pivot->quantity, 0, ',', '.') }}</span>
                                </div>
                            @endforeach

                            @if($booking->promo)
                                <div class="flex justify-between text-green-600">
                                    <span>Promo ({{ $booking->promo->code }})</span>
                                    <span>- DIscount</span>
                                </div>
                            @endif

                            <div
                                class="border-t border-gray-200 mt-2 pt-2 flex justify-between font-bold text-lg text-gray-900">
                                <span>Total</span>
                                <span>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <a href="{{ route('check-queue') }}" class="font-medium text-blue-600 hover:text-blue-500">Cek antrian
                        lain</a>
                </div>
            @else
                {{-- Search Form --}}
                <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10" x-data="{ type: 'phone' }">

                    {{-- Tabs --}}
                    <div class="flex border-b border-gray-200 mb-6">
                        <button @click="type = 'phone'"
                            :class="{ 'border-blue-500 text-blue-600': type === 'phone', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': type !== 'phone' }"
                            class="w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm focus:outline-none">
                            Nomor HP
                        </button>
                        <button @click="type = 'queue'"
                            :class="{ 'border-blue-500 text-blue-600': type === 'queue', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': type !== 'queue' }"
                            class="w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm focus:outline-none">
                            Nomor Antrian
                        </button>
                    </div>

                    <form class="space-y-6" action="{{ route('search-queue') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" x-model="type">

                        <div x-show="type === 'phone'">
                            <label for="phone" class="block text-sm font-medium text-gray-700">
                                Nomor WhatsApp / HP
                            </label>
                            <div class="mt-1">
                                <input id="phone" name="query" type="text" :disabled="type !== 'phone'" required
                                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="Contoh: 08123456789">
                            </div>
                        </div>

                        <div x-show="type === 'queue'" style="display: none;">
                            <label for="queue" class="block text-sm font-medium text-gray-700">
                                ID Antrian
                            </label>
                            <div class="mt-1">
                                <input id="queue" name="query" type="text" :disabled="type !== 'queue'" required
                                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="Contoh: 20260201-5">
                            </div>
                        </div>

                        <div>
                            <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cek Status
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection