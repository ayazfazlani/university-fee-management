<?php

namespace App\Livewire\InvoiceSystem;

use Livewire\Component;
use App\Models\FeeStructures;
use Masmerise\Toaster\Toaster;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Installments; // Import the Installment model

class Installment extends Component
{
    public $installments = [], $amount, $dueDate, $feeStructureId, $selectedInstallment, $structure, $data, $voucher;


    public function mount($feeStructureId)
    {
        // Fetch installments for the given fee structure ID
        $this->installments = Installments::where('fee_structure_id', $feeStructureId)->get();

        // Fetch fee structures with patients
        $this->structure = FeeStructures::with('patient')->get();
    }



    public function store()
    {
        $this->validate([
            'feeStructureId' => 'required|exists:fee_structures,id', // Validate feeStructureId
            'amount' => 'required|numeric', // Validate amount
            'dueDate' => 'required|date', // Validate dueDate
        ]);

        // Create Installment
        Installment::create([ // Use Installment instead of Installments
            'fee_structure_id' => $this->feeStructureId,
            'amount' => $this->amount,
            'due_date' => $this->dueDate,
        ]);

        // Reset form and show success message
        $this->reset(['feeStructureId', 'amount', 'dueDate']);
        // $this->mount();
        $this->dispatch('pop');
        $this->dispatch('showAlert', 'success', 'Installment created successfully!');
        Toaster::success('Installment created successfully!');
    }

    public function edit($id)
    {
        $this->dispatch('popUpShow');
        $this->selectedInstallment = Installments::find($id); // Use Installment instead of Installments
        $this->feeStructureId = $this->selectedInstallment->fee_structure_id;
        $this->amount = $this->selectedInstallment->amount;
        $this->dueDate = $this->selectedInstallment->due_date;
    }

    public function update()
    {
        $this->validate([
            'feeStructureId' => 'required|exists:fee_structures,id', // Validate feeStructureId
            'amount' => 'required|numeric', // Validate amount
            'dueDate' => 'required|date', // Validate dueDate
        ]);

        // Update Installment
        $this->selectedInstallment->update([
            'fee_structure_id' => $this->feeStructureId,
            'amount' => $this->amount,
            'due_date' => $this->dueDate,
        ]);

        // Reset form and show success message
        $this->dispatch('pop');
        $this->dispatch('showAlert', 'success', 'Installment updated successfully!');
        Toaster::success('Installment updated successfully!');
    }

    public function delete($id)
    {
        $installment = Installment::find($id); // Use Installment instead of Installments
        $installment->delete();

        // Show success message
        $this->dispatch('showAlert', 'warning', 'Installment deleted successfully!');
        Toaster::warning('Installment deleted successfully!');
    }

    public function popUp()
    {
        $this->dispatch('popUpShow');
    }

    public function popUpHide()
    {
        $this->dispatch('pop');
        $this->reset(['feeStructureId', 'amount', 'dueDate']); // Reset installment fields
    }

    public $selectedInstallmentId = null;



    public function viewVoucher($installmentId)
    {
        $this->selectedInstallmentId = $installmentId;
        $this->dispatch('showVoucherModal');
    }

    public function closeVoucher()
    {
        $this->selectedInstallmentId = null;
        $this->dispatch('hideVoucherModal');
    }


    public function render()
    {
        return view('livewire.invoice-system.installment', [
            'installments' => $this->installments,
            'structure' => $this->structure, // Pass the structure to the view
        ]);
    }
}