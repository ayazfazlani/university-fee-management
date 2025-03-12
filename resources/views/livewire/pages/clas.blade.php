<div wire:ignore.self>
    <div>
        <!-- Header Section -->
        <div class="col-lg-10 col-md-6 d-flex flex-row flex-wrap gap-4 align-items-center p-2 m-6 mb-0 shadow-sm">
            <!-- Dropdown Section -->
         
            <!-- Filter Button -->
            <button type="button" class="btn btn-outline-secondary btn-lg mt-5">
                Filter
            </button>
            <!-- Add Button -->
            <button type="button" class="btn btn-outline-primary btn-lg mt-5" wire:click="popUp">
                Add
            </button>
        </div>
        
        <!-- Modal Session -->
        <div  class="modal fade" id="model" wire:ignore.self>
          <div class="modal-dialog modal-dialog-centered">
              <form wire:submit.prevent="{{ $selectedClass ? 'update' : 'save' }}" class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="modalCenterTitle">Add/Edit session</h5>
                      <button type="button" class="btn-close" wire:click="popUpHide"></button>
                  </div>
                  <div class="modal-body">
                      <div class="row g-6">
                          <div class="col mb-3">
                              <label class="form-label">Name</label>
                              <input
                                  type="text"
                                  wire:model="name"
                                  class="form-control"
                                  placeholder="Enter class name here"
                              />
                              @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                          </div>
                         
                      </div>
                  </div>
                  <div class="modal-footer gap-2">
                      <button
                          type="button"
                          class="btn btn-outline-secondary"
                          wire:click="popUpHide"
                      >
                          Close
                      </button>
                      <button type="submit" class="btn btn-primary">{{ $selectedClass ? 'Update' : 'Save' }}</button>
                  </div>
              </form>
          </div>
      </div>
      
        
    
        <!-- session Table Section -->
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="card">
                    <h5 class="card-header">session List</h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sessions as $session)
                                    <tr>
                                        <td>{{ $session->name }}</td>
                                        {{-- <td>{{ Carbon\carbon::parse($session->start_date)->format('d M, Y') }}</td>
                                        <td>{{ Carbon\carbon::parse($session->end_date)->format('d M, Y') }}</td> --}}
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                  <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                  <a class="dropdown-item" wire:click="edit({{ $session->id }})"
                                                    ><i class="bx bx-edit-alt me-1"></i> Edit</a
                                                  >
                                                  <a class="dropdown-item" wire:click="delete({{ $session->id }})"
                                                    ><i class="bx bx-trash me-1"></i> Delete</a
                                                  >
                                                </div>
                                              </div>
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
 $wire.on('popUpShow' , () =>{
    $('#model').modal('show');
    });
    $wire.on('pop' , () =>{
    $('#model').modal('hide');
    });
</script>
   

@endscript
    
  
</div>