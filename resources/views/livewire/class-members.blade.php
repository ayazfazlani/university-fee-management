<div wire:ignore.self>
    <div>
        <!-- Header Section -->
        <div class="col-lg-10 col-md-6 d-flex flex-row flex-wrap gap-4 align-items-center p-2 m-6 mb-0 shadow-sm">
            <!-- Filter Button -->
            <!-- Add Button -->
            <button type="button" class="btn btn-sm btn-outline-primary btn-lg mt-5" wire:click="exportVouchers">
                Export To Excel
            </button>
            <button type="button" class="btn btn-sm btn-outline-danger btn-lg mt-5" wire:click="exportPdf">
                Export To PDF
            </button>
        </div>
  
        <!-- Voucher Modal Section -->
        <div wire:ignore.self class="modal fade" id="vcher" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-sm">
                    <div class="modal-header">
                        <h4 class="modal-title font-bold"><i class="bi bi-receipt"></i> Voucher Details</h4>
                        <button type="button" class="btn-close" wire:click="close"></button>
                    </div>
                    <div class="modal-body">
                        @if ($voucherDetails)
                            <div class="border rounded p-3 mb-3">
                                <!-- Display Image or PDF -->
                                <div class="text-center mb-2">
                                    @if (pathinfo($voucherDetails->voucher_image, PATHINFO_EXTENSION) === 'pdf')
                                        <iframe src="{{ asset('storage/' . $voucherDetails->voucher_image) }}" 
                                                class="img-fluid rounded shadow-sm"
                                                style="width: 100%; height: 400px;">
                                        </iframe>
                                    @else
                                        <img src="{{ asset('storage/' . $voucherDetails->voucher_image) }}" 
                                             class="img-fluid rounded shadow-sm" 
                                             alt="Voucher Image" 
                                             style="max-width: 400px; max-height: 250px;">
                                    @endif
                                </div>
                                
                                <!-- Voucher Details Table -->
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
                                                    {{ $voucherDetails->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center p-4">
                                <i class="bi bi-exclamation-circle text-warning fs-3"></i>
                                <p class="text-muted">No vouchers available.</p>
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
        </div>

        <!-- Students Table Section -->
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="card">
                    <h5 class="card-header">Students List</h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Roll no</th>
                                    <th>Section</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                @php
                                    $semesterVoucher = $student->vouchers->where('semester_id', $semester_id)->first();
                                @endphp
                            
                                <tr wire:key="student-{{ $student->id }}">
                                    <td>{{ $student->user->name }}</td>
                                    <td>{{ $student->roll_number }}</td>
                                    <td>{{ $student->section->name }}</td>
                                    <td>{{ $semesterVoucher?->status ?? 'No Voucher' }}</td>
                            
                                    <td>
                                        @if($semesterVoucher)
                                            <button class="btn btn-sm btn-primary" wire:click="show({{ $semesterVoucher->id }})">View</button>
                                            <button class="btn btn-sm btn-success" wire:click="approve({{ $semesterVoucher->id }})">Approve</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            
                            
                            </tbody>
                        </table>
                        <a href="{{ route('semesters') }}" class="btn btn-sm m-2 btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i>
                            Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @script
    <script>
        $wire.on('view', () => {
            $('#vcher').modal('show');
        });
        $wire.on('close', () => {
            $('#vcher').modal('hide');
        });
    </script>
    @endscript
</div>