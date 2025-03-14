<?php

namespace App\Exports;

use App\Models\Voucher;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ClassVouchersPdfExport implements FromView
{
    protected $semester_id;
    protected $section_id;

    public function __construct($semester_id, $section_id)
    {
        $this->semester_id = $semester_id;
        $this->section_id = $section_id;
    }

    public function view(): View
    {
        $vouchers = Voucher::whereHas('student', function ($query) {
            $query->where('section_id', $this->section_id);
        })->where('semester_id', $this->semester_id)
            ->get();

        return view('exports.vouchers-pdf', compact('vouchers'));
    }

    public function download()
    {
        $pdf = Pdf::loadView('exports.vouchers-pdf', ['vouchers' => $this->view()->getData()['vouchers']])
            ->setPaper('a4', 'portrait');

        return $pdf->download('vouchers.pdf');
    }
}
