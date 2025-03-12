<div wire:ignore.self>
    <div>
        <!-- Header Section -->
        <div class="col-lg-10 col-md-6 d-flex flex-row flex-wrap gap-4 align-items-center p-2 m-6 mb-0 shadow-sm">
            <!-- Filter Button -->
            <button type="button" class="btn btn-outline-secondary btn-lg mt-5">
                Filter
            </button>
            <!-- Add Button -->
            <button type="button" class="btn btn-outline-primary btn-lg mt-5" wire:click="popUp">
                Add
            </button>
        </div>
  
        <!-- Modal Section -->
        <div wire:ignore.self class="modal fade" id="modal">
            <div class="modal-dialog modal-dialog-centered">
                <form wire:submit.prevent="{{ $selectedInstallment ? 'update' : 'store' }}" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $selectedInstallment ? 'Edit Installment' : 'Add Installment' }}</h5>
                        <button type="button" class="btn-close" wire:click="popUpHide"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <!-- Fee Structure ID -->
                            <div class="col-md-6">
                                <label for="feeStructureId" class="form-label">Fee Structure</label>
                                <select id="feeStructureId" wire:model="feeStructureId" class="form-control">
                                    <option value="">Select Fee Structure</option>
                                    @foreach($structure as $fee)
                                        <option value="{{ $fee->id }}">{{ $fee->patient->name }} - {{ $fee->amount }}</option>
                                    @endforeach
                                </select>
                                @error('feeStructureId') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                  
                            <!-- Amount -->
                            <div class="col-md-6">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" id="amount" wire:model="amount" class="form-control" placeholder="Enter amount">
                                @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                  
                            <!-- Due Date -->
                            <div class="col-md-6">
                                <label for="dueDate" class="form-label">Due Date</label>
                                <input type="date" id="dueDate" wire:model="dueDate" class="form-control" placeholder="Enter due date">
                                @error('dueDate') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer gap-2">
                        <button type="button" class="btn btn-outline-secondary" wire:click="popUpHide">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">{{ $selectedInstallment ? 'Update' : 'Save' }}</button>
                    </div>
                </form>
            </div>
        </div>
  
        <!-- Installments Table Section -->
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="card">
                    <h5 class="card-header">Installments List</h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Fee Structure</th>
                                    <th>Amount</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($installments as $installment)
                                    <tr>
                                        <td>
                                            @if ($installment->feeStructure)
                                                {{ $installment->feeStructure->patient->name }}
                                            @else
                                                <span class="text-danger">Fee Structure Deleted</span>
                                            @endif
                                        </td>
                                        <td>{{ $installment->amount }}</td>
                                        <td>{{ $installment->due_date }}</td>
                                        <td>
                                            @if ($installment->is_paid)
                                                <span class="badge rounded bg-label-success">Paid</span>
                                            @else
                                                <span class="badge rounded bg-label-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{-- <button class="btn btn-sm btn-info" wire:click="show({{ $installment->id }})">Installments</button> --}}
                                            <button class="btn btn-sm btn-primary" wire:click="edit({{ $installment->id }})">Edit</button>
                                            <button class="btn btn-sm btn-danger" wire:click="delete({{ $installment->id }})">Delete</button>
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
  
    @script
    <script>
        $wire.on('popUpShow', () => {
            $('#modal').modal('show');
        });
        $wire.on('pop', () => {
            $('#modal').modal('hide');
        });
    </script>
    @endscript
</div>