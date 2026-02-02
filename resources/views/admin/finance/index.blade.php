@extends('admin.layouts.app')

@section('title', 'Keuangan')
@section('header', 'Keuangan')

@section('content')
    <div class="mb-6 flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="flex gap-2">
            <button onclick="document.getElementById('addTransactionModal').classList.remove('hidden')"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                + Tambah Transaksi Manual
            </button>
        </div>

        <form action="{{ route('admin.finance.index') }}" method="GET" class="flex gap-2">
            <select name="type" onchange="this.form.submit()" class="rounded-lg border-gray-300 text-sm">
                <option value="">Semua Tipe</option>
                <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
                <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
            </select>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Tanggal</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Tipe</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Deskripsi</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Jumlah</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Input Oleh</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($transactions as $t)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $t->date->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <span
                                class="px-2 py-1 rounded-full text-xs font-bold {{ $t->type == 'income' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $t->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $t->description }}</td>
                        <td class="px-6 py-4 text-sm font-bold {{ $t->type == 'income' ? 'text-green-600' : 'text-red-500' }}">
                            Rp {{ number_format($t->amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $t->user->name ?? 'Sistem' }}
                            <div class="text-xs text-gray-400">{{ $t->created_at->format('H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button onclick="editTransaction({{ $t }})"
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium mr-2">Edit</button>
                            <form action="{{ route('admin.finance.destroy', $t) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium"
                                    onclick="return confirm('Hapus transaksi ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada data transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $transactions->links() }}
        </div>
    </div>

    <!-- Create/Edit Modal -->
    <div id="addTransactionModal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-md p-6">
            <h3 class="text-lg font-bold mb-4" id="modalTitle">Tambah Transaksi</h3>
            <form id="transactionForm" action="{{ route('admin.finance.store') }}" method="POST">
                @csrf
                <div id="methodField"></div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                        <select name="type" id="typeInput" class="w-full rounded-lg border-gray-300">
                            <option value="income">Pemasukan</option>
                            <option value="expense">Pengeluaran</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                        <input type="date" name="date" id="dateInput" class="w-full rounded-lg border-gray-300" required
                            value="{{ date('Y-m-d') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah (Rp)</label>
                        <input type="number" name="amount" id="amountInput" class="w-full rounded-lg border-gray-300"
                            required min="0">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="description" id="descInput" rows="3"
                            class="w-full rounded-lg border-gray-300"></textarea>
                    </div>
                </div>

                <div class="mt-6 flex gap-3 justify-end">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function closeModal() {
            document.getElementById('addTransactionModal').classList.add('hidden');
            document.getElementById('transactionForm').reset();
            document.getElementById('transactionForm').action = "{{ route('admin.finance.store') }}";
            document.getElementById('methodField').innerHTML = '';
            document.getElementById('modalTitle').innerText = 'Tambah Transaksi';
            document.getElementById('typeInput').disabled = false;
        }

        function editTransaction(data) {
            document.getElementById('addTransactionModal').classList.remove('hidden');
            document.getElementById('modalTitle').innerText = 'Edit Transaksi';

            let form = document.getElementById('transactionForm');
            form.action = "{{ route('admin.finance.update', ':id') }}".replace(':id', data.id);
            document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';

            document.getElementById('typeInput').value = data.type;
            // document.getElementById('typeInput').disabled = true; // Maybe allow changing type? Plan said separate manual input, but editing typically allows fixing mistakes. Let's keep it editable or disabled as per logic. Usually type change is rare.

            document.getElementById('dateInput').value = data.date.split('T')[0];
            document.getElementById('amountInput').value = data.amount;
            document.getElementById('descInput').value = data.description;
        }
    </script>
@endsection