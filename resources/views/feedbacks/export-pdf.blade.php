<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Report</title>
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
        <h1>Feedback Report</h1>
        <p>Generated on {{ \Carbon\Carbon::now()->toFormattedDateString() }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Transaction ID</th>
                <th>Feedback</th>
                <th>Submitted At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($feedbacks as $feedback)
                <tr>
                    <td>{{ $feedback->user->name }}</td>
                    <td>{{ $feedback->transaction->id ?? 'N/A' }}</td>
                    <td>{{ $feedback->feedback }}</td>
                    <td>{{ $feedback->created_at->format('d M Y, H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        <p>© {{ date('Y') }} Auction Management System • Confidential</p>
    </div>
</body>
</html>
