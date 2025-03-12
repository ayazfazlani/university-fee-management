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
                <form wire:submit.prevent="{{ $selectedPatient ? 'update' : 'store' }}" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $selectedPatient ? 'Edit Doctor' : 'Add Doctor' }}</h5>
                        <button type="button" class="btn-close" wire:click="popUpHide"></button>
                    </div>
                    <div class="modal-body">
                      <div class="row g-3">
                          <!-- Patient Name -->
                          <div class="col-md-6">
                            <label for="branch_id" class="form-label">Branch</label>
                            <select
                                id="PatientId"
                                wire:model="PatientId"
                                class="form-control"
                            >
                                <option value="">Select Branch</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                @endforeach
                            </select>
                            @error('PatientId') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                  
                          <!-- Guardian Name -->
                          <div class="col-md-6">
                              <label for="guardianName" class="form-label">Total Amount</label>
                              <input
                                  type="number"
                                  id="TotalAmount"
                                  wire:model="TotalAmount"
                                  class="form-control"
                                  placeholder="Enter guardian name"
                              />
                              @error('TotalAmount') <span class="text-danger">{{ $message }}</span> @enderror
                          </div>
                  
                          <!-- Guardian Relation -->
                          <div class="col-md-6">
                              <label for="guardianRelation" class="form-label">Installments</label>
                              <input
                                  type="number"
                                  id="InstallmentCount"
                                  wire:model="InstallmentCount"
                                  class="form-control"
                                  placeholder="Enter no of installments"
                              />
                              @error('InstallmentCount') <span class="text-danger">{{ $message }}</span> @enderror
                          </div>
                  
                          <!-- Guardian Phone -->
                          <div class="col-md-6">
                              <label for="guardianPhone" class="form-label">Due Date</label>
                              <input
                                  type="date"
                                  id="DueDate"
                                  wire:model="DueDate"
                                  class="form-control"
                                  placeholder="Enter guardian phone"
                              />
                              @error('DueDate') <span class="text-danger">{{ $message }}</span> @enderror
                          </div>
                  
                          <!-- Patient Phone -->
                          {{-- <div class="col-md-6">
                              <label for="phone" class="form-label">Phone</label>
                              <input
                                  type="text"
                                  id="phone"
                                  wire:model="phone"
                                  class="form-control"
                                  placeholder="Enter phone"
                              />
                              @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                          </div>
                  
                          <!-- Admitted At -->
                          <div class="col-md-6">
                              <label for="admittedAt" class="form-label">Admitted At</label>
                              <input
                                  type="date"
                                  id="admittedAt"
                                  wire:model="admittedAt"
                                  class="form-control"
                                  placeholder="Enter admission date"
                              />
                              @error('admittedAt') <span class="text-danger">{{ $message }}</span> @enderror
                          </div>
                  
                          <!-- Branch Selection -->
                          <div class="col-md-6">
                              <label for="branch_id" class="form-label">Branch</label>
                              <select
                                  id="branch_id"
                                  wire:model="branchId"
                                  class="form-control"
                              >
                                  <option value="">Select Branch</option>
                                  @foreach($branches as $branch)
                                      <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                  @endforeach
                              </select>
                              @error('branchId') <span class="text-danger">{{ $message }}</span> @enderror
                          </div>
                   --}}
                          <!-- Optional: Role and Password Fields (Commented Out) -->
                          {{--
                          <div class="col-md-6">
                              <label for="role" class="form-label">Role</label>
                              <select
                                  id="role"
                                  wire:model="role"
                                  class="form-control"
                              >
                                  <option value="">Select Role</option>
                                  <option value="super_admin">Super Admin</option>
                                  <option value="branch_admin">Branch Admin</option>
                                  <option value="doctor">Doctor</option>
                                  <option value="user">User</option>
                              </select>
                              @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                          </div>
                          <div class="col-md-6">
                              <label for="password" class="form-label">Password</label>
                              <input
                                  type="password"
                                  id="password"
                                  wire:model="password"
                                  class="form-control"
                                  placeholder="Enter password"
                              />
                              @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                          </div>
                          --}}
                      </div>
                  </div>
                    <div class="modal-footer gap-2">
                        <button type="button" class="btn btn-outline-secondary" wire:click="popUpHide">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">{{ $selectedPatient ? 'Update' : 'Save' }}</button>
                    </div>
                </form>
            </div>
        </div>
  
        <!-- Doctors Table Section -->
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="card">
                    <h5 class="card-header">Users List</h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Patient name</th>
                                    <th>Amount</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                            </thead>
                            <tbody>
                                @foreach($fees as $fee)
                                    <tr>
                                        <td>{{ $fee->patient->name }}</td>
                                        <td>{{ $fee->amount }}</td>
                                        <td>{{ $fee->due_date }}</td>
                                        <td>
                                        @if ($fee->is_paid == 1)
                                        <span class="badge rounded bg-label-success">Paid</span>
                                        @elseif ($fee->is_paid == 0) 
                                        <span class="badge rounded bg-label-warning">Pending</span>  
                                        @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm bg-label-info" wire:click="show({{ $fee->id }})">Installments</button>
                                            <button class="btn btn-sm bg-label-primary" wire:click="edit({{ $fee->id }})">Edit</button>
                                            <button class="btn btn-sm bg-label-danger" wire:click="delete({{ $fee->id }})">Delete</button>
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