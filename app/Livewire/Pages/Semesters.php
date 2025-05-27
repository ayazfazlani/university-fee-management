<?php

namespace App\Livewire\Pages;

use App\Models\Section;
use Livewire\Component;
use App\Models\Semester;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\Auth;

class Semesters extends Component
{
    public $name, $sessionId;
    public $semesters, $sessions, $selectedSemester;

    public function mount()
    {
        if (Auth::user()->hasRole(['Admin', 'Super Admin', 'HOD'])) {
            $this->sessions = Section::all();
            // dd(Auth::user()->student->section->sesion->id);

            $this->semesters = Semester::with('section')->get();
        } elseif (Auth::user()->hasRole('CR')) {
            $this->sessions = Section::all();
            // dd($this->sessions);
            $this->semesters = Semester::with('section')->where('section_id', Auth::user()->student->section->id)->get();
        } else {
            $this->sessions = [];
            $this->semesters = [];
        }
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string',
            'sessionId' => 'required|exists:sections,id',
        ]);

        Semester::create([
            'name' => $this->name,
            'section_id' => $this->sessionId,
        ]);

        $this->dispatch('pop');
        // Dispatch success alert and use Toaster for notification
        $this->dispatch('showAlert',  'success', 'Semester added successfully!');
        $this->reset(['name', 'sessionId']);
        $this->mount(); // Refresh data
    }

    public function edit($id)
    {
        $this->dispatch('popUpShow');
        $this->selectedSemester = Semester::find($id);
        $this->name = $this->selectedSemester->name;
        $this->sessionId = $this->selectedSemester->section_id;
    }

    public function update()
    {
        $this->selectedSemester->update([
            'name' => $this->name,
            'section_id' => $this->sessionId,
        ]);


        $this->dispatch('pop');
        // Dispatch success alert and use Toaster for notification
        $this->dispatch('showAlert',  'success', 'Semester updated successfully!');
        $this->reset(['name', 'sessionId']);
        $this->mount(); // Refresh data
    }

    public function delete($id)
    {
        Semester::find($id)->delete();
        $this->dispatch('showAlert',  'success', 'Semester deleted successfully!');
        $this->mount(); // Refresh data
    }
    public function popUp()
    {
        $this->reset(['name', 'sessionId']);
        $this->dispatch('popUpShow');
    }
    public function popUpHide()
    {
        $this->dispatch('pop');
        $this->reset(['name', 'sessionId']);
    }
    public function render()
    {
        return view('livewire.pages.semesters', [
            'semesters' => $this->semesters,
        ]);
    }
}