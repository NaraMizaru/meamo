<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::latest()->paginate(10);
        return view('admin.items.index', compact('items'));
    }

    public function create()
    {
        return view('admin.items.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:items,name',
        ]);

        Item::create($validated);

        return redirect()->route('admin.items.index')
            ->with('success', 'Item created successfully!');
    }

    public function edit(Item $item)
    {
        return view('admin.items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:items,name,' . $item->id,
        ]);

        $item->update($validated);

        return redirect()->route('admin.items.index')
            ->with('success', 'Item updated successfully!');
    }

    public function destroy(Item $item)
    {
        // Optional: Check if used in services/addons before delete
        $item->delete();

        return redirect()->route('admin.items.index')
            ->with('success', 'Item deleted successfully!');
    }
}
