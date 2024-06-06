<!-- Button trigger modal -->
<a href="#edit{{ $subject->id }}" class="btn" data-bs-toggle="modal" data-bs-target="#edit{{ $subject->id }}" 
    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit subject">
    <button class="btn btn-warning btn-sm d-flex gap-2"><i class="fa-solid fa-pencil mt-1"></i> Edit</button>
</a>
   
<!-- Modal -->
<div class="modal fade" id="edit{{ $subject->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('subject.update', $subject->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                
            
                    <label for="subjects" class="mb-3">Subject *</label>
                    <input type="text" name="subjects" placeholder="Add Subject" value="{{ $subject->subjects }}" class="form-control mb-3 @error('subjects') is-invalid @enderror" value="{{$subject->subjects}}" required>
                   
                      
                    
                        <label for="written_works" class="mb-3">Written Works *</label>
                        <input type="number" name="written_works" id="written_works" placeholder="Written Works" class="form-control mb-3 @error('written_works') is-invalid @enderror" value="{{$subject->written_works}}" required>
                        @error('written_works')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                
                    
                    
                             
                        <label for="performance_task" class="mb-3">Performance task *</label>
                        <input type="number" name="performance_task" id="performance_task" placeholder="Performance Task" class="form-control mb-3 @error('performance_task') is-invalid @enderror" value="{{$subject->performance_task}}" required>
                        @error('performance_task')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                  
                    
                   
                        <label for="assessment" class="mb-3">Assessment *</label>
                        <input type="number"  name="assessment" id="assessment" placeholder="Assessment" class="form-control mb-3 @error('assessment') is-invalid @enderror" value="{{$subject->assessment}}" required>
                        @error('assesment')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    
                
                  
              
                
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
                
            </form>
        </div>
    </div>
</div>
