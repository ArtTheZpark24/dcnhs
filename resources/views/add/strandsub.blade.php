<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
    <i class="fa-solid fa-plus"></i>  Add subject
  </button>
  
 
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('strandsub.create', ['id' => $strand->id]) }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-3 fw-bold">Subject list</h5>
                            <div class="row">
                                @foreach ($subjects as $subject)
                                    <div class="col-md-6">
                                        <div class="form-check mb-3">
                                            <input type="checkbox" class="form-check-input @error('subject_id.' . $subject->id) is-invalid @enderror" id="subject_{{ $subject->id }}" name="subject_id[]" value="{{ $subject->id }}" {{ in_array($subject->id, $strandSubjects->pluck('subject_id')->toArray()) ? 'disabled' : '' }}>
                                            <label class="form-check-label" for="subject_{{ $subject->id }}">{{ $subject->subjects }}</label>
                                            @if(in_array($subject->id, $strandSubjects->pluck('subject_id')->toArray()))
                                                <div class="invalid-feedback">One or more selected subjects do not exist.</div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label for="semester_id">Semester *</label>
                            <select name="semester_id" id="semester_id" class="form-control @error('semester_id') is-invalid @enderror" required>
                                @foreach ($semesters as $semester )
                                    <option value="{{ $semester->id }}"> {{ $semester->semester }}</option>
                                @endforeach
                            </select>
                            @error('semester_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <label for="grade_level_id" class="mt-3">Grade Level*</label>
                            <select name="grade_level_id" id="grade_level_id" class="form-control @error('grade_level_id') is-invalid @enderror" required>

                                @foreach ($gradeLevels as $level )
                                    <option value="{{ $level->id }}">{{ $level->level }}</option>
                                @endforeach
                            </select>
                            @error('grade_level_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add</button>

                </form>
            </div>
        </div>
    </div>
</div>
