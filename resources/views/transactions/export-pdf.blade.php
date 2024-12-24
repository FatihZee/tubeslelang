<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Report</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: 'Arial', sans-serif;
            background: #1a1a1a;
            color: #fff;
            padding: 40px;
        }
        .header {
            background: #3b0764;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #fff;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #a5b4fc;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #333;
            color: #fff;
        }
        td {
            background-color: #262626;
            color: #d1d5db;
            border-top: 1px solid #404040;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Transaction Report</h1>
        <p>Generated on {{ \Carbon\Carbon::now()->toFormattedDateString() }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Winner</th>
                <th>Nominal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->bid->auction->product->name ?? 'Unknown' }}</td>
                    <td>{{ $transaction->user->name }}</td>
                    <td>{{ number_format($transaction->nominal, 2) }}</td>
                    <td>{{ ucfirst($transaction->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        <p>© {{ date('Y') }} Auction Management System • Confidential</p>
    </div>
</body>
</html>
