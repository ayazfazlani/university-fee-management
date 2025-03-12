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
        <div wire:ignore.self class="modal fade"  id="modal">
            <div class="modal-dialog modal-dialog-centered">
                <form wire:submit.prevent="{{ $selectedVoucher ? 'update' : 'store' }}" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $selectedVoucher ? 'Edit Voucher' : 'Add Voucher' }}</h5>
                        <button type="button" class="btn-close" wire:click="popUpHide"></button>
                    </div>
                    <div class="modal-body">
                      <div class="row g-3">
                        {{-- name --}}
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Student Name</label>
                            <input
                                type="text"
                                id="name"
                                wire:model="name"
                                class="form-control"
                                value="{{Auth::user()->name}}"
                                disabled
                            />
                            @error('studnt') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Voucher No</label>
                            <input
                                type="text"
                                id="voucherNumber"
                                wire:model="voucherNumber"
                                class="form-control"
                                placeholder="Please enter voucher number"
                            />
                            @error('voucherNumber') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                          <!-- amount -->
                          <div class="col-md-6">
                              <label for="phone" class="form-label">Amount paid</label>
                              <input
                                  type="number"
                                  id="amount"
                                  wire:model="amount"
                                  class="form-control"
                                  placeholder="Enter amount paid"
                              />
                              @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
                          </div>
                          {{-- image  --}}
                          <div class="col-md-6">
                            <label for="voucherImage" class="form-label">Vouchre image</label>
                            <input
                                type="file"
                                id="voucherImage"
                                wire:model="voucherImage"
                                class="form-control"

                            />
                            @error('voucherImage') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                          <!-- Payment Date -->
                          <div class="col-md-6">
                              <label for="admissionDate" class="form-label">Fee submit date</label>
                              <input
                                  type="date"
                                  id="paymentDate"
                                  wire:model="paymentDate"
                                  class="form-control"
                                  placeholder="Enter submission date"
                              />
                              @error('paymentDate') <span class="text-danger">{{ $message }}</span> @enderror
                          </div>
                  
                          <div class="col-md-6">
                              <label for="semesterId" class="form-label">Semester</label>
                              <select
                                  id="semesterId"
                                  wire:model="semesterId"
                                  class="form-control"
                              >
                                  <option value="">Select semester</option>
                                  @foreach($semesters as $semester)
                                      <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                                  @endforeach
                              </select>
                              @error('semesterId') <span class="text-danger">{{ $message }}</span> @enderror
                          </div>
                      </div>
                  </div>
                    <div class="modal-footer gap-2">
                        <button type="button" class="btn btn-outline-secondary" wire:click="popUpHide">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">{{ $selectedVoucher ? 'Update' : 'Save' }}</button>
                    </div>
                </form>
            </div>
        </div>
  
        {{-- view voucher  --}}
        <div wire:ignore.self class="modal fade" id="vcher"  tabindex="-1">
         
           <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-sm">
                <div class="modal-header  ">
                    <h4 class="modal-title font-bold"><i class="bi bi-receipt"></i> Voucher Details</h4>
                    <button type="button" class="btn-close text-white" wire:click="close"></button>
                </div>
                <div class="modal-body">
                    @if ($vouchers->isEmpty())
                        <div class="text-center p-4">
                            <i class="bi bi-exclamation-circle text-warning fs-3"></i>
                            <p class="text-muted">No vouchers available.</p>
                        </div>
                    @else
                    @if($voucherDetails)
                            <div class="border rounded p-3 mb-3">
                                <!-- Image Display -->
                                {{-- <div class="text-center mb-2">
                                    <img src="{{ asset('storage/' . $voucherDetails->voucher_image) }}" 
                                        class="img-fluid rounded shadow-sm" 
                                        alt="Voucher Image" style="max-width: 400px; max-height: 250px;">
                                </div> --}}

                                <div class="text-center mb-2">
                                    @if (pathinfo($voucher->voucher_image, PATHINFO_EXTENSION) === 'pdf')
                                        <!-- Display PDF -->
                                        <iframe src="{{ asset('storage/' . $voucher->voucher_image) }}" 
                                                class="img-fluid rounded shadow-sm"
                                                style="width: 100%; height: 400px;">
                                        </iframe>
                                    @else
                                        <!-- Display Image -->
                                        <img src="{{ asset('storage/' . $voucher->voucher_image) }}" 
                                             class="img-fluid rounded shadow-sm" 
                                             alt="Voucher Image" 
                                             style="max-width: 400px; max-height: 250px;">
                                    @endif
                                </div>
                                
                                
                                <table class="table table-sm table-borderless">
                                    <tbody>
                                        <tr>
                                            <td><strong><i class="bi bi-person"></i> Student:</strong></td>
                                            <td>{{ $voucherDetails->student->user->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong><i class="bi bi-book"></i> Semester:</strong></td>
                                            <td>{{ $voucherDetails->semester->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong><i class="bi bi-card-list"></i> Roll Number:</strong></td>
                                            <td>{{ $voucherDetails->student->roll_number }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong><i class="bi bi-calendar-check"></i> Payment Date:</strong></td>
                                            <td>{{ \Carbon\Carbon::parse($voucherDetails->payment_date)->format('d M, Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong><i class="bi bi-cash"></i> Amount:</strong></td>
                                            <td><span class="fw-bold text-success">Rs. {{ number_format($voucherDetails->amount, 2) }}</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong><i class="bi bi-file-earmark-text"></i> Voucher no:</strong></td>
                                            <td>{{ $voucherDetails->voucher_number }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong><i class="bi bi-check-circle"></i> Status:</strong></td>
                                            <td>
                                                <span class="badge {{ $voucherDetails->status === 'Paid' ? 'bg-success' : 'bg-warning text-dark' }}">
                                                    {{ $voucher->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" wire:click="close">
                        <i class="bi bi-x"></i> Close
                    </button>
                </div>
            </div>
        </div>

           @endif
        </div>
        
        
        <!-- Doctors Table Section -->
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="card">
                    <h5 class="card-header">Vouchers List</h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Session</th>
                                    <th>Section
                                    </th>
                                    <th>Semester</th>
                                    <th>Roll No</th>
                                    <th>Status</th>
                                    <th>Submission Date</th>
                          
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vouchers as $voucher)
                                    <tr wire:key="{{ $voucher->id }}">
                                        <td>{{ $voucher->student->user->name }}</td>
                                        <td>{{ $voucher->student->section->sesion->name }}</td>
                                        <td>{{ $voucher->student->section->name }}</td>
                                        <td>{{ $voucher->semester->name }}</td>
                                        <td>{{ $voucher->student->roll_number }}</td>
                                       <td>
                                        
                                        @if (strtolower($voucher->status) == "approved")
                                        <p class="badge bg-label-success">Approved</p>
                                    @else
                                        <p class="badge bg-label-info">Pending</p>
                                    @endif
                                    
                                    
                                       </td>
                                        <td>{{ $voucher->payment_date }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" wire:click="show({{ $voucher->id }})">view</button>
                                            <button class="btn btn-sm btn-primary" wire:click="edit({{ $voucher->id }})">Edit</button>
                                            <button class="btn btn-sm btn-danger" wire:click="delete({{ $voucher->id }})">Delete</button>
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

        $wire.on('view', () => {
            $('#vcher').modal('show');
        });
        $wire.on('close', () => {
            $('#vcher').modal('hide');
        });
    </script>
    @endscript
  </div>