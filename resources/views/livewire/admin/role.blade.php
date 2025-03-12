<div class="container">
    <h2>Role Management</h2>


    <form wire:submit.prevent="{{ $updateMode ? 'update' : 'store' }}">
        <div class="mb-3">
            <label for="name">Role Name</label>
            <input type="text" wire:model="name" class="form-control">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <h5>Select Permissions</h5>
        @foreach ($permissions as $permission)
            <div class="form-check">
                <input type="checkbox" wire:model="selectedPermissions" value="{{ $permission->name }}" class="form-check-input">
                <label class="form-check-label">{{ $permission->name }}</label>
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary mt-3">
            {{ $updateMode ? 'Update Role' : 'Create Role' }}
        </button>

        @if ($updateMode)
            <button type="button" wire:click="resetInput" class="btn btn-secondary mt-3">Cancel</button>
        @endif
    </form>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>Name</th>
                <th>Permissions</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>
                        @foreach ($role->permissions as $permission)
                            <span class="badge m-1 bg-label-primary sm">{{ $permission->name }}</span>
                        @endforeach
                    </td>
                    <td class="btn-group gap-1">
                        <button wire:click="edit({{ $role->id }})" class="btn btn-warning btn-sm">Edit</button>
                        <button wire:click="delete({{ $role->id }})" class="btn btn-danger btn-sm" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

