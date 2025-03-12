<div>
  <div class="header">
      <h2>Medical Clinic Name</h2>
      <p>123 Clinic Address, City</p>
  </div>

  <div class="details">
      <h3>Voucher #{{ $voucher->id }}</h3>
      <p>Patient: {{ $voucher->feeStructure->patient->name }}</p>
      <p>Amount: ${{ number_format($voucher->amount, 2) }}</p>
      <p>
          Due Date: {{ \Carbon\Carbon::parse($voucher->due_date)->format('M d,
          Y') }}
      </p>
  </div>

  <div class="footer">
      <p>Generated on: {{ $date }}</p>
      <p>Authorized Signature: ___________________</p>
  </div>
</div>
