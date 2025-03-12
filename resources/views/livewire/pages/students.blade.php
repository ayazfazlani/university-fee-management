<div wire:ignore.self>
  <div>
      <!-- Header Section -->
      <div class="col-lg-10 col-md-6 d-flex flex-row flex-wrap gap-4 align-items-center p-2 m-6 mb-0 shadow-sm">
          <!-- Filter Button -->
          <button type="button" class="btn  btn-sm  btn-outline-secondary btn-lg mt-5">
              Filter
          </button>
          <!-- Add Button -->
          <button type="button" class="btn  btn-sm  btn-outline-primary btn-lg mt-5" wire:click="popUp">
              Add
          </button>
      </div>

      <!-- Modal Section -->
      <div wire:ignore.self class="modal fade" id="modal">
          <div class="modal-dialog modal-dialog-centered">
              <form wire:submit.prevent="{{ $selectedStudent ? 'update' : 'store' }}" class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title">{{ $selectedStudent ? 'Edit Student' : 'Add Student' }}</h5>
                      <button type="button" class="btn-close" wire:click="popUpHide"></button>
                  </div>
                  <div class="modal-body">
                    <div class="row g-3">
                        <!-- Patient Name -->
                        <div class="col-md-6">
                            <label for="branch_id" class="form-label">Name</label>
                            <select
                                id="userId"
                                wire:model="userId"
                                class="form-control"
                            >
                                <option value="">Select student</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('userId') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        {{-- <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input
                                type="text"
                                id="name"
                                wire:model="name"
                                class="form-control"
                                placeholder="Enter patient name"
                            />
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div> --}}
                        <!-- Patient Phone -->
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Roll No</label>
                            <input
                                type="text"
                                id="rollNo"
                                wire:model="rollNo"
                                class="form-control"
                                placeholder="Enter roll number"
                            />
                            @error('rollNo') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                
                        <!-- Admitted At -->
                        <div class="col-md-6">
                            <label for="admissionDate" class="form-label">Admission Date</label>
                            <input
                                type="date"
                                id="admissionDate"
                                wire:model="admissionDate"
                                class="form-control"
                                placeholder="Enter admission date"
                            />
                            @error('admissionDate') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                
                        <div class="col-md-6">
                            <label for="name" class="form-label">Amount</label>
                            <input
                                type="number"
                                id="integer"
                                wire:model="amount"
                                class="form-control"
                                placeholder="Enter amaount"
                            />
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Section Selection -->
                        <div class="col-md-6">
                            <label for="branch_id" class="form-label">Section</label>
                            <select
                                id="sectionId"
                                wire:model="sectionId"
                                class="form-control"
                            >
                                <option value="">Select Section</option>
                                @foreach($sections as $section)
                                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                                @endforeach
                            </select>
                            @error('sectionId') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                  <div class="modal-footer gap-2">
                      <button type="button" class="btn btn-outline-secondary" wire:click="popUpHide">
                          Close
                      </button>
                      <button type="submit" class="btn btn-primary">{{ $selectedStudent ? 'Update' : 'Save' }}</button>
                  </div>
              </form>
          </div>
      </div>

      <!-- Doctors Table Section -->
      <div class="content-wrapper">
          <div class="container-xxl flex-grow-1 container-p-y">
              <div class="card">
                  <h5 class="card-header">Students List</h5>
                  <div class="table-responsive text-nowrap">
                      <table class="table">
                          <thead>
                              <tr>
                                  <th>Name</th>
                                  <th>Roll No</th>
                                  <th>Session</th>
                                  <th>Section</th>
                                  <th>Status</th>
                                  <th>Admision Date</th>
                        
                              </tr>
                          </thead>
                          <tbody>
                            {{-- {{ dd($students) }} --}}
                              @foreach($students as $user)
                                  <tr>
                                      <td>{{ $user->user->name }}</td>
                                      <td>{{ $user->roll_number }}</td>
                                      <td>{{ $user->section->sesion->name }}</td>
                                      <td>{{ $user->section->name }}</td>
                                     <td>
                                        @if ($user->status == 1)
                                        <p class="badge bg-label-success">Active</p>
                                        @else
                                           <p class="badge bg-label-info">Pending</p>
                                        @endif
                                     </td>
                                      <td>{{ $user->admission_date }}</td>
                                      <td>
                                          <button class="btn btn-sm btn-primary" wire:click="edit({{ $user->id }})">Edit</button>
                                          <button class="btn btn-sm btn-danger" wire:click="delete({{ $user->id }})">Delete</button>
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