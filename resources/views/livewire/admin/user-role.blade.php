<div class="container">
    <h3>Assign Role to User</h3>
    <div class="btn btn-group gap-1">
      
        <select class="form-select" wire:model="selectedUser">
            <option value="">Select User</option>
            @foreach ($users as $user)
                <option  value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    
        <select wire:model="selectedRole" class="form-select">
            <option value="">Select Role</option>
            @foreach ($roles as $role)
                <option value="{{ $role->name }}">{{ $role->name }}</option>
            @endforeach
        </select>
    
    </div>
    <button class="btn btn-primary" wire:click="assignRole">Assign Role</button>

    @if (session()->has('message'))
        <p>{{ session('message') }}</p>
    @endif

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card">
                <h5 class="card-header">Users and Their Roles</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Actions</th>
                                </tr>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td> <button wire:click="deleteUser({{ $user->id }})" class="btn btn-danger btn-sm" onclick="confirm('Are you sure, you want to delete {{ $user->name  }} ?') || event.stopImmediatePropagation()">Delete</button></td>
                    <td>
                        @foreach($user->roles as $role)
                            <span class="badge bg-info text-white">{{ $role->name }}</span>
                        @endforeach
                    </td>

                    <td>
                        @foreach($user->roles as $role)
                            <button wire:click="removeRole({{ $user->id }}, '{{ $role->name }}')" class="btn btn-danger btn-sm" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">Remove {{ $role->name }}</button>
                        @endforeach
                    </td>
                </tr>
            @endforeach
                        
                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
  
</div>
