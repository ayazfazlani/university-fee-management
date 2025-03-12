<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Spatie\Permission\Models\Permission;

class Permissions extends Component
{
    public $permissions, $name, $permissionId;
    public $updateMode = false;


    public function resetInput()
    {
        $this->name = '';
        $this->permissionId = null;
        $this->updateMode = false;
    }

    public function store()
    {
        $this->validate(['name' => 'required|unique:permissions']);

        Permission::create(['name' => $this->name]);
        $this->dispatch('showAlert',  'success', 'Permission created successfully!');
        Toaster::success('Permission created successfully!');
    }

    public function edit($id)
    {
        $permission = Permission::find($id);
        $this->permissionId = $permission->id;
        $this->name = $permission->name;
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate(['name' => "required|unique:permissions,name,{$this->permissionId}"]);

        $permission = Permission::find($this->permissionId);
        $permission->update(['name' => $this->name]);

        $this->dispatch('showAlert',  'success', 'Permission updated successfully!');
        Toaster::success('Permission updaated successfully!');
        $this->resetInput();
    }

    public function delete($id)
    {
        Permission::find($id)->delete();
        $this->dispatch('showAlert',  'success', 'Permission deleted successfully!');
        Toaster::success('Permission deleted successfully!');
    }
    public function render()
    {
        $this->permissions = Permission::all();
        return view('livewire.admin.permission');
    }
}