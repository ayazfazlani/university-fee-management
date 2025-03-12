<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Installment Voucher</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .voucher {
            border: 1px solid #ddd;
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .details {
            margin-bottom: 20px;
        }
        .row {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="voucher">
        <div class="header">
            <h2>Installment Voucher</h2>
            <p>Date: {{ $date }}</p>
        </div>
        <div class="details">
            <div class="row">
                <strong>Voucher No:</strong> {{ $voucher->id }}
            </div>
            <div class="row">
                <strong>Patient Name:</strong> {{ $voucher->feeStructure->patient->name }}
            </div>
            <div class="row">
                <strong>Amount:</strong> {{ number_format($voucher->amount, 2) }}
            </div>
            <div class="row">
                <strong>Due Date:</strong> {{ \Carbon\Carbon::parse($voucher->due_date)->format('M d, Y') }}
            </div>
        </div>
    </div>
</body>
</html>