<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Service;
use App\Models\Schedule;
use App\Models\Template;
use App\Models\TemplateCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->take(6)->get();
        $services = Service::all();

        return view('user.home', compact('galleries', 'services'));
    }

    public function templates(Request $request)
    {
        $categories = TemplateCategory::orderBy('name')->get();

        $templates = Template::with('category')
            ->where('status', true)
            ->when($request->category, function ($query) use ($request) {
                $query->where('template_category_id', $request->category);
            })
            ->latest()
            ->paginate(12)
            ->withQueryString(); // penting: filter tetap saat pagination

        return view('user.templates', compact('templates', 'categories'));
    }

    public function gallery()
    {
        $galleries = Gallery::latest()->paginate(12);
        return view('user.gallery', compact('galleries'));
    }

    public function services()
    {
        $services = Service::all();
        return view('user.services', compact('services'));
    }

    public function schedules()
    {
        $query = Schedule::where('status', 'available')
            ->where('event_date', '>=', now())
            ->orderBy('event_date');

        // Apply date filters if provided
        if (request('from')) {
            $query->where('event_date', '>=', request('from'));
        }
        if (request('to')) {
            $query->where('event_date', '<=', request('to'));
        }

        $schedules = $query->paginate(12);

        return view('user.schedules', compact('schedules'));
    }

    public function contact()
    {
        return view('user.contact');
    }
}
