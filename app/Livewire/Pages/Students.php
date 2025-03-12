<?php

namespace App\Livewire\Pages;

use App\Models\Section;
use App\Models\Student;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Students extends Component
{
    public $name, $users, $userId, $amount, $sectionId, $rollNo, $admissionDate;
    public $students, $branches, $selectedStudent;

    public function mount()
    {
        $this->users = User::all();
        $this->students = Student::with('user', 'semester')->get();



        // dd($data);
        $this->userId = Auth::user()->id; // Fetch all Students

    }

    public function store()
    {
        // dd('hello');
        $this->validate([
            'sectionId' => 'required|exists:sections,id',
            'rollNo' => 'nullable|string',
            'amount' => 'required|numeric',
            'admissionDate' => 'required|date'
        ]);
        $data = [
            'user_id' => $this->userId,
            'section_id' => $this->sectionId,
            'roll_number' => $this->rollNo,
            'fee_amount' => $this->amount,
            'admission_date' => $this->admissionDate,
        ];
        // dd($data);
        Student::create($data);

        $this->dispatch('pop');
        $this->dispatch('showAlert', 'success', 'Student added successfully!');
        $this->reset();
        $this->mount(); // Refresh data
    }

    public function edit($id)
    {
        $this->dispatch('popUpShow');
        $this->selectedStudent = Student::find($id);
        // $this->name = $this->selectedStudent->name;

        $this->sectionId = $this->selectedStudent->section_id;
        $this->rollNo = $this->selectedStudent->roll_number;
        $this->amount = $this->selectedStudent->fee_amount;
        $this->admissionDate = $this->selectedStudent->admission_date;
    }

    public function update()
    {
        $this->selectedStudent->update([
            // 'name' => $this->name,
            'section_id' => $this->sectionId,
            'roll_number' => $this->rollNo,
            'fee_amount' => $this->amount,
            'admission_date' => $this->admissionDate,
        ]);


        $this->dispatch('pop');
        $this->dispatch('showAlert', 'success', 'Student updated successfully!');
        $this->reset();
        $this->mount(); // Refresh data
    }

    public function delete($id)
    {
        Student::find($id)->delete();
        $this->dispatch('showAlert', 'success', 'Student deleted successfully!');
        $this->mount(); // Refresh data
    }

    public function popUp()
    {
        $this->dispatch('popUpShow');
        $this->reset('selectedStudent', 'name', 'sectionId', 'rollNo', 'admissionDate');
    }

    public function popUpHide()
    {
        $this->dispatch('pop');
        $this->reset('selectedStudent', 'name', 'sectionId',  'rollNo', 'admissionDate');
    }

    public function render()
    {
        return view('livewire.pages.students', [
            'sections' => Section::get(), // Fetch all sectionsF
        ]);
    }
}
