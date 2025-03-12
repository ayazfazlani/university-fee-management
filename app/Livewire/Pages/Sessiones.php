<?php

namespace App\Livewire\Pages;


use App\Models\sesion;
use Livewire\Component;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;

class sessiones extends Component
{
    public $name, $startDate, $endDate;
    public $selectedPatient;




    public function save()
    {
        // Validate the input data
        $this->validate([
            'name' => 'required',
            'startDate' => 'required',
            'endDate' => 'required',
        ]);

        // Attempt to create the sesion
        $data = [
            'name' => $this->name,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
        ];

        // dd($data);
        Sesion::create($data);
        $this->reset(['name', 'startDate', 'endDate']);
        $this->dispatch('pop');
        // Dispatch success alert and use Toaster for notification
        $this->dispatch('showAlert',  'success', 'sesion created successfully!');
        Toaster::success('sesion created successfully!');



        // return redirect()->back();
    }
    public function delete($id)
    {
        $sesion = sesion::find($id);

        if ($sesion) {
            $sesion->delete();
            $this->dispatch('showAlert',  'warning', 'sesion deleted successfully!');
            Toaster::warning('sesion deleted successfully!');
        } else {

            $this->dispatch('showAlert',  'warning', 'There was issue while deleting the sesion!');
            Toaster::warning('There was issue while deleting the sesion!');
        }
    }

    public function edit($id)
    {
        $this->dispatch('popUpShow');
        $this->selectedPatient = sesion::find($id);
        $this->name = $this->selectedPatient->name;
        $this->startDate = $this->selectedPatient->start_date;
        $this->endDate = $this->selectedPatient->end_date;
    }

    public function update()
    {
        // Validate the input data
        $validated = $this->validate([
            'name' => 'required',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
        ]);

        $data = [
            'name' => $this->name,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
        ];
        // Attempt to create the sesion
        try {
            // $sesion = sesion::find($this->sesionId);
            $this->selectedPatient->update($data);
            $this->reset(['name', 'startDate', 'endDate']);
            $this->dispatch('pop');
            // Dispatch success alert and use Toaster for notification
            $this->dispatch('showAlert',  'success', 'sesion updated successfully!');
            Toaster::success('sesion updated successfully!');
        } catch (\Exception $e) {
            // Handle any exceptions
            $this->dispatch('showAlert', 'error', 'Failed to updated sesion!');
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
        $this->reset(['name', 'startDate', 'endDate']);
    }
    #[Title('Sessions Page')]
    public function render()
    {
        return view('livewire.pages.sessiones', [
            'sessions' => sesion::all(),
        ]);
    }
}
