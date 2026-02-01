<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceAddon;
use App\Models\Item;
use Illuminate\Http\Request;

class ServiceAddonController extends Controller
{
    public function index()
    {
        $addons = ServiceAddon::with('items')->latest()->paginate(10);
        return view('admin.service_addons.index', compact('addons'));
    }

    public function create()
    {
        $items = Item::all();
        return view('admin.service_addons.create', compact('items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'items' => 'nullable|array',
            'items.*.id' => 'exists:items,id',
            'items.*.quantity' => 'nullable|integer|min:1',
        ]);

        $addon = ServiceAddon::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
        ]);

        // Sync Items
        if (!empty($validated['items'])) {
            $syncData = [];
            foreach ($validated['items'] as $itemData) {
                if (isset($itemData['id']) && isset($itemData['quantity'])) {
                    $syncData[$itemData['id']] = ['quantity' => $itemData['quantity']];
                }
            }
            $addon->items()->sync($syncData);
        }

        return redirect()->route('admin.service-addons.index')
            ->with('success', 'Addon created successfully!');
    }

    public function edit(ServiceAddon $serviceAddon)
    {
        $items = Item::all();
        return view('admin.service_addons.edit', compact('serviceAddon', 'items'));
    }

    public function update(Request $request, ServiceAddon $serviceAddon)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'items' => 'nullable|array',
            'items.*.id' => 'exists:items,id',
            'items.*.quantity' => 'nullable|integer|min:1',
        ]);

        $serviceAddon->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
        ]);

        // Sync Items
        $syncData = [];
        if (!empty($validated['items'])) {
            foreach ($validated['items'] as $itemData) {
                if (isset($itemData['id']) && isset($itemData['quantity'])) {
                    $syncData[$itemData['id']] = ['quantity' => $itemData['quantity']];
                }
            }
        }
        $serviceAddon->items()->sync($syncData);

        return redirect()->route('admin.service-addons.index')
            ->with('success', 'Addon updated successfully!');
    }

    public function destroy(ServiceAddon $serviceAddon)
    {
        $serviceAddon->delete();

        return redirect()->route('admin.service-addons.index')
            ->with('success', 'Addon deleted successfully!');
    }
}
