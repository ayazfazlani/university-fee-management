<div wire:ignore.self>
  <div>
      <!-- Header Section -->
      <div class="col-lg-10 col-md-6 d-flex flex-row flex-wrap gap-4 align-items-center p-2 m-6 mb-0 shadow-sm">
          <!-- Filter Button -->
          <button type="button" class="btn  btn-sm  btn-outline-secondary btn-lg mt-5">
              Filter
          </button>
          <!-- Add Button -->
          <button type="button" class="btn  btn-sm btn-outline-primary btn-lg mt-5" wire:click="popUp">
              Add
          </button>
      </div>

      <!-- Modal Section -->
      <div  class="modal fade" id="modeel" wire:ignore.self>
          <div class="modal-dialog modal-dialog-centered">
              <form wire:submit.prevent="{{ $selectedSemester ? 'update' : 'store' }}" class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title">{{ $selectedSemester ? 'Edit Semester' : 'Add Semester' }}</h5>
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
                                placeholder="Enter doctor's name"
                            />
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                
                        <!-- Row 3 -->
                        <div class="col-md-6">
                            <label class="form-label">Semester Name</label>
                            <select
                                wire:model="sessionId"
                                class="form-control"
                            >
                                <option value="">Select Section</option>
                                @foreach($sessions as $session)
                                    <option value="{{ $session->id }}">{{ $session->name }}</option>
                                @endforeach
                            </select>
                            @error('sessionId') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                
                  <div class="modal-footer gap-2">
                      <button type="button" class="btn btn-outline-secondary" wire:click="popUpHide">
                          Close
                      </button>
                      <button type="submit" class="btn btn-primary">{{ $selectedSemester ? 'Update' : 'Save' }}</button>
                  </div>
              </form>
          </div>
      </div>

      <!-- Doctors Table Section -->
      <div class="content-wrapper">
          <div class="container-xxl flex-grow-1 container-p-y">
              <div class="card">
                  <h5 class="card-header">Semesters List</h5>
                  <div class="table-responsive text-nowrap">
                      <table class="table">
                          <thead>
                              <tr>
                                  <th>Name</th>
                                  <th>Section</th>
                                  <th>Actions</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($semesters as $semester)
                                  <tr>
                                      <td>{{ $semester->name }}</td>

                                      <td>{{ $semester->section->name }}</td>
                
                                      <td>
                                        <a class="btn btn-sm btn-info" href="{{ route('class-members', ['semester' => $semester->id, 'section' => $semester->section->id]) }}">View class</a>
                                        {{-- <button class="btn btn-sm btn-info" wire:click="view({{ $semester->id }})">View class</button> --}}
                                          <button class="btn btn-sm btn-primary" wire:click="edit({{ $semester->id }})">Edit</button>
                                          <button class="btn btn-sm btn-danger" wire:click="delete({{ $semester->id }})">Delete</button>
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
