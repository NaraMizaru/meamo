<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $items = \App\Models\Item::all();
        $addons = \App\Models\ServiceAddon::all();
        return view('admin.services.create', compact('items', 'addons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'items' => 'nullable|array',
            'items.*.id' => 'exists:items,id',
            'items.*.quantity' => 'nullable|integer|min:1',
            'addons' => 'nullable|array',
            'addons.*' => 'exists:service_addons,id',
        ]);

        $service = Service::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
        ]);

        // Sync Items
        if (!empty($validated['items'])) {
            $itemSync = [];
            foreach ($validated['items'] as $itemData) {
                if (isset($itemData['id']) && isset($itemData['quantity'])) {
                    $itemSync[$itemData['id']] = ['quantity' => $itemData['quantity']];
                }
            }
            $service->items()->sync($itemSync);
        }

        // Sync Addons
        if (!empty($validated['addons'])) {
            $service->addons()->sync($validated['addons']);
        }

        return redirect()->route('admin.services.index')
            ->with('success', 'Service berhasil ditambahkan!');
    }

    public function edit(Service $service)
    {
        $items = \App\Models\Item::all();
        $addons = \App\Models\ServiceAddon::all();
        return view('admin.services.edit', compact('service', 'items', 'addons'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'items' => 'nullable|array',
            'items.*.id' => 'exists:items,id',
            'items.*.quantity' => 'nullable|integer|min:1',
            'addons' => 'nullable|array',
            'addons.*' => 'exists:service_addons,id',
        ]);

        $service->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
        ]);

        // Sync Items
        $itemSync = [];
        if (!empty($validated['items'])) {
            foreach ($validated['items'] as $itemData) {
                if (isset($itemData['id']) && isset($itemData['quantity'])) {
                    $itemSync[$itemData['id']] = ['quantity' => $itemData['quantity']];
                }
            }
        }
        $service->items()->sync($itemSync);

        // Sync Addons
        if (!empty($validated['addons'])) {
            $service->addons()->sync($validated['addons']);
        } else {
            $service->addons()->detach();
        }

        return redirect()->route('admin.services.index')
            ->with('success', 'Service berhasil diupdate!');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service berhasil dihapus!');
    }
}
