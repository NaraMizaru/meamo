<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::query();

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        $transactions = $query->latest()->paginate(10);

        return view('admin.finance.index', compact('transactions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $validated['user_id'] = Auth::id();

        $transaction = Transaction::create($validated);

        TransactionHistory::create([
            'transaction_id' => $transaction->id,
            'user_id' => Auth::id(),
            'action' => 'created',
            'changes' => ['info' => "Added manually by " . Auth::user()->name],
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $changes = [];
        if ($transaction->amount != $validated['amount']) {
            $changes[] = "Diedit nilai uangnya dari " . number_format((float) $transaction->amount) . " menjadi " . number_format((float) $validated['amount']);
        }
        if ($transaction->description != $validated['description']) {
            $changes[] = "Diedit deskripsi";
        }

        $transaction->update($validated);

        if (!empty($changes)) {
            TransactionHistory::create([
                'transaction_id' => $transaction->id,
                'user_id' => Auth::id(),
                'action' => 'updated',
                'changes' => $changes,
            ]);
        }

        return redirect()->back()->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        // Histories cascade delete or keep? Default cascade in migration, but we might want soft deletes later.
        // For now, hard delete is fine as per migration.

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
    }

    public function history()
    {
        $histories = TransactionHistory::with(['transaction', 'user'])->latest()->paginate(20);
        return view('admin.finance.history', compact('histories'));
    }

    public function analysis()
    {
        // Simple data for charts
        $income = Transaction::where('type', 'income')->sum('amount');
        $expense = Transaction::where('type', 'expense')->sum('amount');

        return view('admin.finance.analysis', compact('income', 'expense'));
    }

    public function exportPdf()
    {
        $transactions = Transaction::with('user')->orderBy('date', 'desc')->get();
        $pdf = Pdf::loadView('admin.finance.pdf', compact('transactions'));
        return $pdf->download('laporan-keuangan.pdf');
    }
}
