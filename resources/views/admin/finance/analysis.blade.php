@extends('admin.layouts.app')

@section('title', 'Analisis Keuangan')
@section('header', 'Analisis Keuangan')

@section('content')
    <div class="mb-6 flex justify-end">
        <a href="{{ route('admin.finance.export-pdf') }}"
            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-bold shadow-md transition-all flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
            </svg>
            Export PDF
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Summary Cards -->
        <div class="bg-green-50 rounded-2xl p-6 border border-green-100">
            <h3 class="text-green-800 font-semibold mb-2">Total Pemasukan</h3>
            <p class="text-3xl font-bold text-green-600">Rp {{ number_format($income, 0, ',', '.') }}</p>
        </div>
        <div class="bg-red-50 rounded-2xl p-6 border border-red-100">
            <h3 class="text-red-800 font-semibold mb-2">Total Pengeluaran</h3>
            <p class="text-3xl font-bold text-red-600">Rp {{ number_format($expense, 0, ',', '.') }}</p>
        </div>

        <!-- Chart -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 col-span-1 md:col-span-2">
            <h3 class="font-bold text-gray-800 mb-4">Grafik Pemasukan vs Pengeluaran</h3>
            <div class="h-64">
                <canvas id="financeChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 col-span-1 md:col-span-2">
            <h3 class="font-bold text-gray-800 mb-4">Keuntungan Bersih</h3>
            <p class="text-4xl font-bold text-blue-600">Rp {{ number_format($income - $expense, 0, ',', '.') }}</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('financeChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut', // or 'bar', 'line'
            data: {
                labels: ['Pemasukan', 'Pengeluaran'],
                datasets: [{
                    label: 'Total (Rp)',
                    data: [{{ $income }}, {{ $expense }}],
                    backgroundColor: [
                        'rgba(34, 197, 94, 0.6)',
                        'rgba(239, 68, 68, 0.6)'
                    ],
                    borderColor: [
                        'rgb(34, 197, 94)',
                        'rgb(239, 68, 68)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    </script>
@endsection