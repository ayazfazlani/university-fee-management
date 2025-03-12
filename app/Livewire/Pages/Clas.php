<?php

namespace App\Livewire\Pages;

use App\Models\Classes;
use App\Models\Sesion;
use Livewire\Component;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;

class Clas extends Component
{
    public $name;
    public $selectedClass;




    public function save()
    {
        // Validate the input data
        $this->validate([
            'name' => 'required',
        ]);

        // Attempt to create the sesion
        $data = [
            'name' => $this->name,
        ];

        // dd($data);
        Classes::create($data);
        $this->reset(['name']);
        $this->dispatch('pop');
        // Dispatch success alert and use Toaster for notification
        $this->dispatch('showAlert',  'success', 'Class created successfully!');
        Toaster::success('sesion created successfully!');



        // return redirect()->back();
    }
    public function delete($id)
    {
        $sesion = Classes::find($id);

        if ($sesion) {
            $sesion->delete();
            $this->dispatch('showAlert',  'warning', 'Class deleted successfully!');
            Toaster::warning('class deleted successfully!');
        } else {

            $this->dispatch('showAlert',  'warning', 'There was issue while deleting the class!');
            Toaster::warning('There was issue while deleting the class!');
        }
    }

    public function edit($id)
    {
        $this->dispatch('popUpShow');
        $this->selectedClass = Classes::find($id);
        $this->name = $this->selectedClass->name;
    }

    public function update()
    {
        // Validate the input data
        $this->validate([
            'name' => 'required',
        ]);

        $data = [
            'name' => $this->name,
        ];
        // Attempt to create the sesion
        try {
            // $sesion = sesion::find($this->sesionId);
            $this->selectedClass->update($data);
            $this->reset(['name']);
            $this->dispatch('pop');
            // Dispatch success alert and use Toaster for notification
            $this->dispatch('showAlert',  'success', 'Class updated successfully!');
            Toaster::success('sesion updated successfully!');
        } catch (\Exception $e) {
            // Handle any exceptions
            $this->dispatch('showAlert', 'error', 'Class to updated class!');
            Toaster::error('Failed to updated sesion!');
        }


        // return redirect()->back();
    }
    public function popUp()
    {
        $this->reset(['name', 'selectedClass']);
        $this->dispatch('popUpShow');
    }
    public function popUpHide()
    {
        $this->dispatch('pop');
        $this->reset(['name', 'selectedClass']);
    }
    #[Title('Classes Page')]

    public function render()
    {
        return view('livewire.pages.clas', [
            'sessions' => Classes::all(),
        ]);
    }
}
