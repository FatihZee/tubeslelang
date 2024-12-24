<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bid Report</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: 'Helvetica', sans-serif;
            background: #1a1a1a;
            margin: 0;
            padding: 40px;
            color: #fff;
        }
        .header {
            background: linear-gradient(135deg, #3b0764, #4c1d95);
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.3);
        }
        .header h1 {
            margin: 0;
            font-size: 36px;
            font-weight: 800;
            letter-spacing: -1px;
            color: #fff;
        }
        .subtext {
            color: #a5b4fc;
            font-size: 14px;
            margin-top: 5px;
        }
        .container {
            background: #262626;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        th {
            background: #333;
            color: #fff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
            padding: 15px 20px;
        }
        td {
            padding: 15px 20px;
            color: #d1d5db;
            border-top: 1px solid #404040;
        }
        tr:hover td {
            background: #2d2d2d;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #6b7280;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Bid Report for Auction: {{ $auction->product->name }}</h1>
        <div class="subtext">Generated on {{ now()->format('F j, Y') }}</div>
    </div>
    
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Bidder</th>
                    <th>Bid Price</th>
                    <th>Bid Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bids as $index => $bid)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $bid->user->name }}</td>
                        <td>{{ number_format($bid->bid_price, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($bid->bid_time)->format('F j, Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>© {{ date('Y') }} Auction Management System • Confidential</p>
    </div>
</body>
</html>