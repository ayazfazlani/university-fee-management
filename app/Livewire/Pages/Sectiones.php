<?php

namespace App\Livewire\Pages;


use App\Models\Section;
use App\Models\Sesion;
use Livewire\Component;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;

class Sectiones extends Component
{
    public $name, $sessionId;
    public $selectedSection;




    public function store()
    {
        // Validate the input data
        $this->validate([
            'name' => 'required',
            'sessionId' => 'required',
        ]);

        // Attempt to create the sesion
        $data = [
            'name' => $this->name,
            'sesion_id' => $this->sessionId,
        ];

        // dd($data);
        Section::create($data);
        $this->reset(['name', 'sessionId']);
        $this->dispatch('pop');
        // Dispatch success alert and use Toaster for notification
        $this->dispatch('showAlert',  'success', 'session created successfully!');
        Toaster::success('sesion created successfully!');



        // return redirect()->back();
    }
    public function delete($id)
    {
        $sesion = Section::find($id);

        if ($sesion) {
            $sesion->delete();
            $this->dispatch('showAlert',  'warning', 'Class deleted successfully!');
            Toaster::warning('session deleted successfully!');
        } else {

            $this->dispatch('showAlert',  'warning', 'There was issue while deleting the class!');
            Toaster::warning('There was issue while deleting the session!');
        }
    }

    public function edit($id)
    {
        $this->dispatch('popUpShow');
        $this->selectedSection = Section::find($id);
        $this->name = $this->selectedSection->name;
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
            $this->selectedSection->update($data);
            $this->reset(['name', 'sessionId']);
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
        $this->dispatch('popUpShow');
    }
    public function popUpHide()
    {
        $this->dispatch('pop');
        $this->reset(['name', 'sessionId']);
    }
    #[Title('Sections Page')]
    public function render()
    {
        return view('livewire.pages.sectiones', [
            'sections' => Section::all(),
            'sessions' => Sesion::all(),
        ]);
    }
}
