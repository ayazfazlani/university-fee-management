<?php

namespace App\Livewire\InvoiceSystem;

use livewire;
use Carbon\Carbon;
use App\Models\Patient;
use Livewire\Component;
use App\Models\Installments;
use App\Models\FeeStructures;
use Masmerise\Toaster\Toaster;
use App\Livewire\InvoiceSystem\Installment;

class FeeStructure extends Component
{
    public $PatientId, $TotalAmount, $InstallmentCount, $DueDate,
        $selectedPatient, $patients, $structure;

    public function mount()
    {
        $this->structure = FeeStructures::with('patient')->get();
        $this->patients = Patient::all();
    }

    public function store()
    {
        $this->validate([
            'PatientId' => 'required|exists:patients,id',
            'TotalAmount' => 'required|numeric',
            'InstallmentCount' => 'required|integer|min:1',
            'DueDate' => 'required|date',
        ]);

        // Create FeeStructure
        $feeStructure = FeeStructures::create([
            'patient_id' => $this->PatientId,
            'amount' => $this->TotalAmount,
            'due_date' => $this->DueDate,
        ]);

        // Generate Installments
        $installmentAmount = $this->TotalAmount / $this->InstallmentCount;
        for ($i = 0; $i < $this->InstallmentCount; $i++) {
            Installments::create([ // Use Installment instead of Installments
                'fee_structure_id' => $feeStructure->id,
                'amount' => $installmentAmount,
                'due_date' => Carbon::parse($this->DueDate)->addMonths($i), // Calculate due date
                'is_paid' => false,
            ]);
        }

        // Reset form and show success message
        $this->reset(['PatientId', 'TotalAmount', 'InstallmentCount', 'DueDate']);
        $this->mount();
        $this->dispatch('pop');
        $this->dispatch('showAlert', 'success', 'Fee created successfully!');
        Toaster::success('Fee created successfully!');
    }

    public function edit($id)
    {
        $this->dispatch('popUpShow');
        $this->selectedPatient = FeeStructures::find($id);
        $this->PatientId = $this->selectedPatient->patient_id;
        $this->TotalAmount = $this->selectedPatient->amount;
        $this->DueDate = $this->selectedPatient->due_date;
    }

    public function update()
    {
        $this->validate([
            'PatientId' => 'required|exists:patients,id',
            'TotalAmount' => 'required|numeric',
            'DueDate' => 'required|date',
        ]);

        $this->selectedPatient->update([
            'patient_id' => $this->PatientId,
            'amount' => $this->TotalAmount,
            'due_date' => $this->DueDate,
        ]);

        $this->dispatch('pop');
        $this->dispatch('showAlert', 'success', 'Fee updated successfully!');
        $this->reset();
        $this->mount(); // Refresh data
    }

    public function delete($id)
    {
        FeeStructures::find($id)->delete();
        $this->dispatch('showAlert', 'success', 'Fee deleted successfully!');
        $this->mount(); // Refresh data
    }

    // show installments for the particular patient 

    public function show($id)
    {
        // Redirect to the Installments component route
        return redirect()->route('installments.show', ['feeStructureId' => $id]);
    }

    public function popUp()
    {
        $this->dispatch('popUpShow');
    }

    public function popUpHide()
    {
        $this->dispatch('pop');
        $this->reset(['PatientId', 'TotalAmount', 'InstallmentCount', 'DueDate']);
    }

    public function render()
    {
        return view('livewire.invoice-system.fee-structure', [
            'patients' => $this->patients,
            'fees' => $this->structure,
        ]);
    }
}
