<a href="#" class="btn link-warning btn-sm mt-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $schoolYear->id }}">
  <button class="btn btn-warning btn-sm"><i class="fa-solid fa-pencil"></i> Edit</button>
</a>

<div class="modal fade" id="editModal{{ $schoolYear->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit School Year</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('school.year.update', ['id' => $schoolYear->id]) }}" method="POST">

            @csrf
            @method('PUT')
            <label for="year_start">School Date End</label>
            <input type="date" id="year_start" value="{{ $schoolYear->date_start }}"  class="form-control mt-3  @error('date_start') is-invalid @enderror" name="date_start">
            <label for="year_end" class="mt-3">School Date End</label>
            <input type="date" id="year_end" value="{{ $schoolYear->date_end }}"  class="form-control mt-3 @error('date_end') is-invalid @enderror" value="{{ old('date_end') }}" name="date_end">
              
    
              <label for="year_start" class="mt-3">School Year Name</label>
              <input type="text" value="{{ $schoolYear->school_year_name }}"  id="school_year_name" name="school_year_name"
               placeholder="School Year name" class="form-control mt-3 @error('school_year_name')
               is-invalid @enderror" value="{{ old('school_year_name') }}" required>
       
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
        </div>
      </div>
    </div>
  </div>