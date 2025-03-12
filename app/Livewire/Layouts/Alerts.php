<?php

namespace App\Livewire\Layouts;

use Livewire\Component;

class Alerts extends Component
{
    public $type = null; // Default to primary
    public $message;
    public $visible = false;

    protected $listeners = ['showAlert'];

    // Method to show alert
    public function showAlert($type, $message)
    {
        // Validate type to avoid invalid classes
        $validTypes = [1, 2, 3, 4, 5, 6, 7];

        // Set the alert type or default to 'primary' if invalid
        $this->type = in_array($type, $validTypes) ? $type : 3;
        $this->message = $message;
        $this->visible = true;

        // Dispatch hide alert after 5 seconds
        $this->dispatch('alert:hide', ['delay' => 5000]);
    }

    // Method to hide the alert
    public function hideAlert()
    {
        $this->visible = false;
    }

    public function render()
    {
        return view('livewire.layouts.alerts');
    }
}
