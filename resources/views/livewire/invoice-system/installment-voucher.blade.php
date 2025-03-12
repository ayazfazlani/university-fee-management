<div>
    @if($voucher)
        <div class="voucher-content">
            <div class="mb-3">
                <strong>Installment No:</strong> {{ $voucher->id }}
            </div>
            <div class="mb-3">
                <strong>Patient Name:</strong> {{ $voucher->feeStructure->patient->name }}
            </div>
            <div class="mb-3">
                <strong>Installment Amount:</strong> {{ number_format($voucher->amount, 2) }}
            </div>
            <div class="mb-3">
                <strong>Due Date:</strong> {{ \Carbon\Carbon::parse($voucher->due_date)->format('M d, Y') }}
            </div>
            <div class="mt-4">
                <button type="button" class="btn btn-primary" 
                        wire:click="downloadVoucher"
                        wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="downloadVoucher">Download PDF</span>
                    <span wire:loading wire:target="downloadVoucher">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Generating...
                    </span>
                </button>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            Voucher not found.
        </div>
    @endif
</div>