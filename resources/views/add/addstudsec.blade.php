<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
  <i class="fa-solid fa-plus"></i> Add Student
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Student list enrolled on this strand {{ $strand->strands }} {{ $level->level }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form action="{{ route('section.student.add', ['section_id' => $section->id]) }}" method="post">
                  @csrf
                  <table class="table table-bordered">
                      <thead>
                          <tr>
                              <th>Student list</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($students as $student)
                              <tr>
                                  <td>
                                      <div class="form-check">
                                          <input type="checkbox" class="form-check-input" id="student_{{ $student->id }}" name="student_id[]" value="{{ $student->id }}"
                                              {{ in_array($student->id, $pluckSection->pluck('student_id')->toArray()) ? 'disabled' : '' }}>
                                          <label class="form-check-label" for="student_{{ $student->id }}">
                                              {{ $student->lastname }}, {{ $student->firstname }} {{ $student->middlename }} ({{ $student->lrn }})
                                          </label>
                                      </div>
                                  </td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
                
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add</button>
              </form>
            
          </div>
      </div>
  </div>
</div>

@include('partials.script')
