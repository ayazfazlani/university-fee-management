<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Voucher;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ClassVouchersExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    protected $classId;
    protected $semesterId;

    public function __construct($classId, $semesterId)
    {
        $this->classId = $classId;
        $this->semesterId = $semesterId;
    }

    public function collection()
    {
        return Voucher::whereHas('student', function ($query) {
            $query->where('section_id', $this->classId);
        })->where('semester_id', $this->semesterId)->get();
    }

    public function headings(): array
    {
        return ['ID', 'Student Name', 'Roll Number', 'Semester', 'Amount', 'Status', 'Payment Date'];
    }

    public function map($voucher): array
    {
        return [
            $voucher->id,
            $voucher->student->user->name ?? 'N/A',
            $voucher->student->roll_number ?? 'N/A',
            $voucher->semester->name ?? 'N/A',
            $voucher->amount,
            $voucher->status,
            $voucher->payment_date ? Carbon::parse($voucher->payment_date)->format('d M Y') : 'N/A',
        ];
    }
}
