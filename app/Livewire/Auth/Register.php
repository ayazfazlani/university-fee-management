<?php

namespace App\Livewire\Auth;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Register extends Component
{
    public $name, $email, $password, $terms;
    public function register()
    {

        try {
            $this->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|min:8',
                'terms' => 'accepted',
            ]);
            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ];
            // dd($data);
            // Example: Create user (Modify based on your needs)
            User::create($data);

            // Reset form after successful registration
            $this->reset();

            $this->dispatch('showAlert',  'success', 'User regstered successfully!');
            Toaster::success('Branch created successfully!');
            return redirect('/login');
        } catch (Exception $e) {
            $this->dispatch('showAlert',  'warning', $e->getMessage());
            Toaster::warning('There was issue while regestring the user!');
        }
    }
    public function render()
    {
        return view('livewire.auth.register')->layout('components.layouts.auth');
    }
}
