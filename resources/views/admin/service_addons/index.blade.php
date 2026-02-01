@extends('admin.layouts.app')

@section('title', 'Service Addons')
@section('header', 'Manage Service Addons')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.service-addons.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Add New Addon
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left">Name</th>
                    <th class="px-6 py-3 text-left">Price</th>
                    <th class="px-6 py-3 text-left">Items Yield</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($addons as $addon)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="font-medium">{{ $addon->name }}</div>
                            <div class="text-sm text-gray-500">{{ $addon->description }}</div>
                        </td>
                        <td class="px-6 py-4">Rp {{ number_format($addon->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            @foreach($addon->items as $item)
                                <span class="badge bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs mr-1">
                                    {{ $item->name }} (x{{ $item->pivot->quantity }})
                                </span>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 flex gap-2">
                            <a href="{{ route('admin.service-addons.edit', $addon) }}"
                                class="text-yellow-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.service-addons.destroy', $addon) }}" method="POST"
                                onsubmit="return confirm('Delete this addon?');">
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
            {{ $addons->links() }}
        </div>
    </div>
@endsection