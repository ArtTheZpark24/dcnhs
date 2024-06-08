<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checklist</title>
    @include('partials.css')
</head>
<body>

@include('studentpartials.navbar')
  
<div class="wrapper">
  @include('partials.maincontent')
  
  <div class="card">
    <div class="card-header bg-primary text-white">
      Checklist
    </div>
    <div class="card-body">
      @foreach ($gradeLevels as $level)
        @foreach ($semesters as $semester)
          <div class="card mt-5">
            <div class="card-header">
              <span>Grade list for grade {{ $level->level }} {{ $semester->semester }}</span>
            </div>
            <div class="card-body">
              @php
                $subjectsFound = false;
              @endphp

              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Subjects</th>
                    <th>Average</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($strandSubjects as $subject)
                    @if ($subject->grade_level_id == $level->id && $subject->semester_id == $semester->id)
                      <tr>
                        <td>{{ $subject->subject }}</td>
                     
                        <td>
                          @if ($subject->has_grades && isset($subject->average_grade))
                            {{ number_format($subject->average_grade, 2) }}
                          @else
                           No Grades
                          @endif
                        </td>
                      </tr>
                      @php
                        $subjectsFound = true;
                      @endphp
                    @endif
                  @endforeach

                  @if (!$subjectsFound)
                    <tr>
                      <td colspan="3">No subjects found for this grade level and semester.</td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        @endforeach
      @endforeach
    </div>
  </div>
</div>

@include('partials.script')

</body>
</html>
