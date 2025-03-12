<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Spatie\Permission\Models\Role;


class UserRole extends Component
{
    public $selectedUser, $selectedRole;
    public $users = [], $roles = [];

    public function mount()
    {
        if (!auth()->user()->hasRole('super admin')) {
            abort(403, 'Unauthorized');
        }

        $this->loadUsers();
        $this->roles = Role::all();
    }

    public function loadUsers()
    {
        $this->users = User::with('roles')->get(); // Load users with their assigned roles
    }
    public function assignRole()
    {
        $this->validate([
            'selectedUser' => 'required|exists:users,id',
            'selectedRole' => 'required|exists:roles,name',
        ]);

        $user = User::find($this->selectedUser);
        $user->syncRoles([$this->selectedRole]); // Assign the role

        $this->dispatch('showAlert',  'success', 'Role assigned successfully!');
        Toaster::success('Role assigned successfully!');
        $this->reset(['selectedUser', 'selectedRole']);
        $this->loadUsers(); // Reload the users to reflect changes
    }

    public function removeRole($userId, $roleName)
    {
        $user = User::find($userId);
        $user->removeRole($roleName); // Remove the role

        $this->dispatch('showAlert',  'success', 'Role removed successfully!');
        Toaster::success('Role removedsuccessfully!');
        $this->loadUsers(); // Reload users to update UI
    }

    public function render()
    {
        return view('livewire.admin.user-role');
    }
}
