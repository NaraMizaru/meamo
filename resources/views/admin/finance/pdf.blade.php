<!DOCTYPE html>
<html>

<head>
    <title>Laporan Keuangan</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }

        th {
            background-color: #f2f2f2;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .income {
            color: green;
        }

        .expense {
            color: red;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Laporan Keuangan</h2>
        <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Tipe</th>
                <th>Deskripsi</th>
                <th>Jumlah</th>
                <th>Input Oleh</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $t)
                <tr>
                    <td>{{ $t->date->format('d/m/Y') }}</td>
                    <td>{{ $t->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}</td>
                    <td>{{ $t->description }}</td>
                    <td class="{{ $t->type }}">Rp {{ number_format($t->amount, 0, ',', '.') }}</td>
                    <td>{{ $t->user->name ?? 'Sistem' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>