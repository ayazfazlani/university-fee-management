<?php

namespace App\Livewire\InvoiceSystem;

use Livewire\Component;
use App\Models\Installments;
use Barryvdh\DomPDF\Facade\Pdf;

class InstallmentVoucher extends Component
{
    public $installmentId;
    public $voucher;

    public function mount($installmentId)
    {
        $this->loadVoucher($installmentId);
    }

    public function loadVoucher($installmentId)
    {
        $this->voucher = Installments::with(['feeStructure.patient'])
            ->findOrFail($installmentId);
    }

    public function downloadVoucher()
    {
        if (!$this->voucher) {
            return;
        }

        $pdf = Pdf::loadView('livewire.invoice-system.voucher-pdf', [
            'voucher' => $this->voucher,
            'date' => now()->format('M d, Y')
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, "voucher-{$this->voucher->id}.pdf");
    }

    public function render()
    {
        return view('livewire.invoice-system.installment-voucher');
    }
}