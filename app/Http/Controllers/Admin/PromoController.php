<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use App\Models\Service;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::latest()->paginate(10);
        return view('admin.promos.index', compact('promos'));
    }

    public function create()
    {
        $services = Service::all();
        return view('admin.promos.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:promos,code',
            'discount_type' => 'required|in:fixed,percentage',
            'discount_value' => 'required|numeric|min:0', // Changed input name to value
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'quota' => 'nullable|integer|min:0',
            'is_auto' => 'boolean',
            'service_id' => 'nullable|exists:services,id',
        ]);

        $promoData = [
            'code' => $validated['code'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'quota' => $validated['quota'],
            'service_id' => $validated['service_id'],
            'is_auto' => $request->has('is_auto'),
        ];

        if ($validated['discount_type'] === 'percentage') {
            $promoData['discount_percentage'] = $validated['discount_value'];
            $promoData['discount_amount'] = null;
        } else {
            $promoData['discount_amount'] = $validated['discount_value'];
            $promoData['discount_percentage'] = null;
        }

        Promo::create($promoData);

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo created successfully!');
    }

    public function edit(Promo $promo)
    {
        $services = Service::all();
        return view('admin.promos.edit', compact('promo', 'services'));
    }

    public function update(Request $request, Promo $promo)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:promos,code,' . $promo->id,
            'discount_type' => 'required|in:fixed,percentage',
            'discount_value' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'quota' => 'nullable|integer|min:0',
            'is_auto' => 'boolean',
            'service_id' => 'nullable|exists:services,id',
        ]);

        $promoData = [
            'code' => $validated['code'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'quota' => $validated['quota'],
            'service_id' => $validated['service_id'],
            'is_auto' => $request->has('is_auto'),
        ];

        if ($validated['discount_type'] === 'percentage') {
            $promoData['discount_percentage'] = $validated['discount_value'];
            $promoData['discount_amount'] = null;
        } else {
            $promoData['discount_amount'] = $validated['discount_value'];
            $promoData['discount_percentage'] = null;
        }

        $promo->update($promoData);

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo updated successfully!');
    }

    public function destroy(Promo $promo)
    {
        $promo->delete();

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo deleted successfully!');
    }
}
