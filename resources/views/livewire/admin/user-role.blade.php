<div class="container">
    <h2>Assign Role to User</h2>
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

    <h3>Users and Their Roles</h3>
    <table class="table mt-4">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
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
