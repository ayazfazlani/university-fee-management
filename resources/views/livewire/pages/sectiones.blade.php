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
        <div wire:ignore.self class="modal fade" id="modeel">
            <div class="modal-dialog modal-dialog-centered">
                <form wire:submit.prevent="{{ $selectedSection ? 'update' : 'store' }}" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $selectedSection ? 'Edit Section' : 'Add Section' }}</h5>
                        <button type="button" class="btn-close" wire:click="popUpHide"></button>
                    </div>
                    <div class="modal-body">
                      <div class="row g-3">
                          <!-- Row 1 -->
                          <div class="col-md-6">
                              <label class="form-label">Name</label>
                              <input
                                  type="text"
                                  wire:model="name"
                                  class="form-control"
                                  placeholder="Enter class name"
                              />
                              @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                          </div>
                  
                          <!-- Row 3 -->
                          <div class="col-md-6">
                              <label class="form-label">Session name</label>
                              <select
                                  wire:model="sessionId"
                                  class="form-control"
                              >
                                  <option value="">Select session</option>
                                  @foreach($sessions as $session)
                                      <option value="{{ $session->id }}">{{ $session->name }}</option>
                                  @endforeach
                              </select>
                              @error('classId') <span class="text-danger">{{ $message }}</span> @enderror
                          </div>
                      </div>
                  </div>
                  
                    <div class="modal-footer gap-2">
                        <button type="button" class="btn btn-outline-secondary" wire:click="popUpHide">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">{{ $selectedSection ? 'Update' : 'Save' }}</button>
                    </div>
                </form>
            </div>
        </div>
  
        <!-- Doctors Table Section -->
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="card">
                    <h5 class="card-header">Sections List</h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Session</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sections as $class)
                                    <tr>
                                        <td>{{ $class->name }}</td>
                                        <td>{{ $class->sesion->name }}</td>
                            <td>
                                            <button class="btn btn-sm btn-primary" wire:click="edit({{ $class->id }})">Edit</button>
                                            <button class="btn btn-sm btn-danger" wire:click="delete({{ $class->id }})">Delete</button>
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
        $('#modeel').modal('show');
        });
        $wire.on('pop' , () =>{
        $('#modeel').modal('hide');
        });
    </script>
       
    
    @endscript
        
  </div>
  