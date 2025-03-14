<?php

namespace App\Livewire;

use App\Models\Student;
use App\Models\Voucher;
use Livewire\Component;
use App\Exports\ClassVouchersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ClassVouchersPdfExport;

class ClassMembers extends Component
{

    public $semester_id, $section_id;
    public $students, $voucherDetails;

    public function mount($semester, $section)
    {
        $this->semester_id = $semester;
        $this->section_id = $section;

        // Fetch students with vouchers filtered by the selected semester
        $this->students = Student::where('section_id', $this->section_id)
            ->with(['vouchers' => function ($query) {
                $query->where('semester_id', $this->semester_id);
            }])
            ->get();
    }


    public function show($id)
    {
        $this->dispatch('view');
        $this->voucherDetails = Voucher::with('student.user', 'semester')->findOrFail($id);
        // $this->dispatch('view');
    }

    public function approve($id)
    {
        // dd($id);
        $voucher = Voucher::findOrFail($id);
        $voucher->update(['status' => 'approved']);

        $this->dispatch('showAlert', 'success', 'Voucher approved successfully!');
    }

    public function exportVouchers()
    {
        return Excel::download(new ClassVouchersExport($this->section_id, $this->semester_id), 'class_vouchers.xlsx');
    }
    public function exportPdf()
    {
        $export = new ClassVouchersPdfExport($this->semester_id, $this->section_id);
        return response()->streamDownload(fn() => print($export->download()->getContent()), 'vouchers.pdf');
    }
    public function close()
    {
        $this->dispatch('close');
    }

    public function render()
    {
        return view('livewire.class-members');
    }
}
