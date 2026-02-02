<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(10);

        return view('admin.accounts.index', compact('users'));
    }

    // Add other CRUD methods if needed, for now mainly listing and probably editing roles.
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => ['required', Rule::in(['user', 'admin', 'admin_web'])],
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update($validated);

        return redirect()->back()->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }
        $user->delete();
        return redirect()->back()->with('success', 'Akun berhasil dihapus.');
    }
}
