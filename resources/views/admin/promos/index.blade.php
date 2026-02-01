@extends('admin.layouts.app')

@section('title', 'Promos')
@section('header', 'Manage Promos')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.promos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Add New Promo
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left">Code</th>
                    <th class="px-6 py-3 text-left">Discount</th>
                    <th class="px-6 py-3 text-left">Validity</th>
                    <th class="px-6 py-3 text-left">Usage</th>
                    <th class="px-6 py-3 text-left">Auto?</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($promos as $promo)
                    <tr>
                        <td class="px-6 py-4 font-bold">{{ $promo->code }}</td>
                        <td class="px-6 py-4">
                            @if($promo->discount_type == 'percentage')
                                {{ $promo->discount_amount }}%
                            @else
                                Rp {{ number_format($promo->discount_amount, 0, ',', '.') }}
                            @endif
                            <div class="text-xs text-gray-500">{{ $promo->service ? $promo->service->name : 'All Services' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            {{ $promo->start_date->format('d M') }} - {{ $promo->end_date->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $promo->used_count }} / {{ $promo->quota ?? '∞' }}
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="px-2 py-1 text-xs rounded {{ $promo->is_auto ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $promo->is_auto ? 'Auto' : 'Manual' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 flex gap-2">
                            <a href="{{ route('admin.promos.edit', $promo) }}" class="text-yellow-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.promos.destroy', $promo) }}" method="POST"
                                onsubmit="return confirm('Delete this promo?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $promos->links() }}
        </div>
    </div>
@endsection