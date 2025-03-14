<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Vouchers Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 100%; max-width: 800px; margin: auto; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; padding: 0; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 5px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 40px; }
        .table, .table th, .table td { border: 1px solid black; }
        .table th, .table td { padding: 10px; text-align: left; }
        .table th { background-color: #f2f2f2; }
        .sign-section { margin-top: 40px; text-align: right; }
        .sign-line { display: inline-block; width: 200px; border-top: 1px solid black; margin-top: 30px; }
        .sign-text { margin-top: 5px; font-size: 14px; }
    </style>
</head>
<body>

<div class="container">
    <!-- Report Title -->
    <div class="header">
        <h2>Class Vouchers Report</h2>
    </div>

    <!-- Class & Semester Details -->
    <table class="info-table">
        <tr>
            <td><strong>Department:</strong> CS & IT</td>
            <td><strong>Class:</strong> BSIT _________</td>
        </tr>
        <tr>
            <td><strong>Semester:</strong> _________</td>
            <td><strong>Section:</strong>  _________</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Generated On:</strong> {{ now()->format('d M Y') }}</td>
        </tr>
    </table>

    <!-- Voucher Table -->
    <table class="table">
        <thead>
            <tr>
                {{-- <th>Voucher ID</th> --}}
                <th>Reg No</th>
                <th>Student Name</th>
                <th>Amount</th>
                <th>Payment Date</th>
                {{-- <th>Status</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($vouchers as $voucher)
                <tr>
                    {{-- <td>{{ $voucher->id }}</td> --}}
                    <td>{{ $voucher->student->roll_number }}</td>
                    <td>{{ $voucher->student->user->name }}</td>
                    <td>{{ number_format($voucher->amount, 2) }}</td>
                    <td>{{ $voucher->payment_date }}</td>
                    {{-- <td>{{ ucfirst($voucher->status) }}</td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Signature Section -->
    <div class="sign-section">
        <div class="sign-line"></div>
        <div class="sign-text">Head of Department</div>
    </div>
</div>

</body>
</html>
