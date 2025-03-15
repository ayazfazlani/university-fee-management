<?php

namespace App\Livewire\Pages;

use App\Models\Student;
use App\Models\Voucher;
use Livewire\Component;
use App\Models\Semester;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Voucheres extends Component
{
    use WithFileUploads;

    public $studentId, $semesterId, $voucherImage, $voucherNumber, $amount, $paymentDate, $paymentMethod, $status;
    public $voucheres, $students, $semesters, $selectedVoucher, $voucherDetails = [];

    public function mount()
    {
        $user = Auth::user();
        if ($user->hasRole(['Super Admin', 'Admin'])) {
            $this->voucheres = Voucher::with('student', 'semester')->get();
            $this->studentId = Auth::user()->student->id;
            $this->students = Student::with('user', 'semester')->get();
            // how to get particular section and sessions semesters 
            $this->semesters = Semester::where(
                'section_id',
                Student::where('user_id', Auth::user()->id)->first()->section_id
            )->get();
            // dd($this->studentId);
        } elseif ($user->hasRole('CR')) {
            $this->voucheres = Voucher::with('student', 'semester')->where('student_id', Auth::user()->student->id)->get();
            $this->students = Student::with('user', 'semester')->where('user_id', Auth::user()->id)->get();
            $this->studentId = Auth::user()->student->id;
            $this->semesters = Semester::where(
                'section_id',
                Student::where('user_id', Auth::user()->id)->first()->section_id
            )->get();
        } else {
            $this->voucheres = Voucher::with('student', 'semester')->where('student_id', Auth::user()->student->id)->get();
            $this->students = Student::with('user', 'semester')->where('user_id', Auth::user()->id)->get();
            $this->studentId = Auth::user()->student->id;
            $this->semesters = Semester::where(
                'section_id',
                Student::where('user_id', Auth::user()->id)->first()->section_id
            )->get();
        }
    }


    public function store()
    {
        $this->validate([
            'semesterId' => 'required|exists:semesters,id',
            'voucherNumber' => 'required|string',
            'amount' => 'required|numeric',
            'paymentDate' => 'required|date',
            'voucherImage' => 'required|mimes:jpeg,png,jpg,pdf|max:2048'
        ]);

        $imagePath = $this->voucherImage->store('vouchers', 'public'); // Save in storage/app/public/vouchers

        Voucher::create([
            'student_id' => Auth::user()->student->id,
            'semester_id' => $this->semesterId,
            'voucher_image' => $imagePath,
            'voucher_number' => $this->voucherNumber,
            'amount' => $this->amount,
            'payment_date' => $this->paymentDate,
        ]);

        $this->dispatch('pop');
        $this->dispatch('showAlert', 'success', 'voucher added successfully!');
        $this->reset();
        $this->mount();
    }

    public function show($id)
    {
        $this->voucherDetails = Voucher::with('student.user', 'semester')->findOrFail($id);
        $this->dispatch('view');
    }

    public function edit($id)
    {
        $this->dispatch('popUpShow');
        $this->selectedVoucher = Voucher::findOrFail($id);
        $this->studentId = $this->selectedVoucher->student_id;
        $this->semesterId = $this->selectedVoucher->semester_id;
        $this->voucherNumber = $this->selectedVoucher->voucher_number;
        $this->amount = $this->selectedVoucher->amount;
        $this->paymentDate = $this->selectedVoucher->payment_date;
        $this->paymentMethod = $this->selectedVoucher->payment_method;
        $this->status = $this->selectedVoucher->status;
    }

    public function update()
    {
        $this->validate([
            'semesterId' => 'required|exists:semesters,id',
            'voucherNumber' => 'required|string',
            'amount' => 'required|numeric',
            'paymentDate' => 'required|date',
            'voucherImage' => 'nullable|image|max:2048',
        ]);

        $voucher = Voucher::findOrFail($this->selectedVoucher->id);

        if ($this->voucherImage) {
            // Delete old file if a new one is uploaded
            Storage::disk('public')->delete($voucher->voucher_image);
            $voucher->voucher_image = $this->voucherImage->store('vouchers', 'public');
        } else {
            $voucher->voucher_image = $this->voucherImage->store('vouchers', 'public');
        }

        $voucher->update([
            'student_id' => $this->studentId,
            'semester_id' => $this->semesterId,
            'voucher_number' => $this->voucherNumber,
            'amount' => $this->amount,
            'payment_date' => $this->paymentDate,
            'payment_method' => $this->paymentMethod,
            'status' => $this->status,
            'voucher_image' => $voucher->voucher_image, // Update image if changed
        ]);

        $this->dispatch('pop');
        $this->dispatch('showAlert', 'success', 'voucher updated successfully!');
        $this->reset();
        $this->mount(); // Refresh data
    }

    public function delete($id)
    {
        $voucher = Voucher::findOrFail($id);
        Storage::disk('public')->delete($voucher->voucher_image); // Delete file
        $voucher->delete();


        $this->dispatch('showAlert', 'success', 'voucher deleted successfully!');
        $this->mount();
    }

    public function close()
    {
        $this->dispatch('close');
    }
    public function popUp()
    {
        $this->dispatch('popUpShow');
        $this->reset(['selectedVoucher', 'studentId', 'semesterId', 'voucherImage', 'voucherNumber', 'amount', 'paymentDate', 'paymentMethod', 'status']);
    }

    public function popUpHide()
    {
        $this->dispatch('pop');
        $this->reset(['selectedVoucher', 'studentId', 'semesterId', 'voucherImage', 'voucherNumber', 'amount', 'paymentDate', 'paymentMethod', 'status']);
    }

    public function render()
    {
        // how to get semester of the student to which the student session is enrolled
        $semesters = Semester::all();
        return view('livewire.pages.voucher', [
            'vouchers' => $this->voucheres,
            'students' => $this->students,
            'semesters' => $semesters,
            'voucher' => $this->voucherDetails
        ]);
    }
}
