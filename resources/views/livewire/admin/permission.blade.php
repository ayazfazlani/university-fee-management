<div class="container mt-4">
    <h2 class="mb-3">Manage Permissions</h2>
    
    <!-- Input Group for Adding Permission -->
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Enter permission name" wire:model="name">
        <button class="btn btn-primary" wire:click="store">Add Permission</button>
    </div>

    <!-- Permissions List -->
    <div class="card shadow-sm">
        <div class="card-body">
            <ul class="list-group">
                @foreach ($permissions as $permission)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $permission->name }}
                        <button wire:click="delete({{ $permission->id }})" class="btn btn-danger btn-sm" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">Delete</button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
