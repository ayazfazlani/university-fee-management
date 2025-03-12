<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Roles extends Component
{
    public $roles, $permissions, $name, $selectedPermissions = [], $roleId;
    public $updateMode = false;


    public function resetInput()
    {
        $this->name = '';
        $this->selectedPermissions = [];
        $this->roleId = null;
        $this->updateMode = false;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|unique:roles',
            'selectedPermissions' => 'array'
        ]);

        $role = Role::create(['name' => $this->name]);
        $role->syncPermissions($this->selectedPermissions);

        $this->dispatch('showAlert',  'success', 'Role created successfully!');
        Toaster::success('Role created successfully!');
        $this->resetInput();
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $this->roleId = $role->id;
        $this->name = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
            'name' => "required|unique:roles,name,{$this->roleId}",
            'selectedPermissions' => 'array'
        ]);

        $role = Role::find($this->roleId);
        $role->update(['name' => $this->name]);
        $role->syncPermissions($this->selectedPermissions);

        $this->dispatch('showAlert',  'success', 'Role updated successfully!');
        Toaster::success('Role updated successfully!');
        $this->resetInput();
    }

    public function delete($id)
    {
        Role::find($id)->delete();
        $this->dispatch('showAlert',  'success', 'Role deleted successfully!');
        Toaster::success('Role deleted successfully!');
    }

    public function render()
    {
        $this->roles = Role::with('permissions')->get();
        $this->permissions = Permission::all();
        return view('livewire.admin.role');
    }
}
