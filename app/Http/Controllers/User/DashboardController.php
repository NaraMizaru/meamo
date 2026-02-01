<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $bookings = $user->bookings()->with(['service', 'schedule'])->latest()->get();

        return view('user.dashboard', compact('user', 'bookings'));
    }
}
