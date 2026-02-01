@extends('user.layouts.app')

@section('title', 'Home')

@section('content')
    <section class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20 text-center">
        <h1 class="text-5xl font-bold mb-4">Welcome to Meamo Photo Booth</h1>
        <p class="text-xl mb-8">Capture Your Precious Moments</p>
        @if(!Auth::check() || !Auth::user()->isAdmin())
            <a href="{{ route('booking.create') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold">
                Book Now
            </a>
        @endif
    </section>

    <section class="py-16 max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Our Services</h2>

        <div class="grid md:grid-cols-4 gap-8">
            @foreach($services as $service)
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-semibold">{{ $service->name }}</h3>
                    <p class="text-gray-600">{{ Str::limit($service->description, 100) }}</p>
                    <p class="text-blue-600 font-bold mt-4">
                        Rp {{ number_format($service->price, 0, ',', '.') }}
                    </p>
                </div>
            @endforeach
        </div>
    </section>
@endsection