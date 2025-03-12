<?php

namespace App\Livewire\Auth;

use App\Models\User;
use PHPUnit\Exception;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{

    public $email, $password;

    public function login()
    {
        try {

            $this->validate([
                'email' => 'required|email',
                'password' => 'required|string'
            ]);

            $data = ['email' => $this->email, 'password' => $this->password];
            // dd($data);
            $login = Auth::attempt($data);
            if ($login) {
                $this->dispatch('showAlert',  'success', 'User logged in successfully!');
                Toaster::success('User loged in successfully!');
                return redirect('/');
            } else {
                $this->dispatch('showAlert',  'warning', 'wrong email or password!');
                // Toaster::success('wrong email or password!');
                return redirect('/');
            }
        } catch (Exception $e) {
            $this->dispatch('showAlert',  'warning', $e->getMessage());
            Toaster::success('there was an issue!');
        }
    }
    public function render()
    {
        return view('livewire.auth.login')->layout('components.layouts.auth');
    }
}
