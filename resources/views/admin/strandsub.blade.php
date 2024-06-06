<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $strand->strands }}</title>
    @include('partials.css')
</head>
<body>

  @include('partials.navbar')
  


  <div class="wrapper">
    


    


     

@include('partials.maincontent')

@include('add.strandsub')
@include('partials.message')
   @foreach ($gradeLevels as $level)
    @foreach ($semesters as $semester)
        <div class="card mt-5">
            <div class="card-header bg-primary text-white">
                <span>Subject list for grade {{ $level->level }} {{ $semester->semester }}</span>
            </div>
            <div class="card-body">
                @php
                    $subjectsFound = false;
                @endphp

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Subject Name</th>
                           <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($strandSubjects as $subject)
                            @if ($subject->grade_level_id == $level->id && $subject->semester_id == $semester->id)
                                <tr>
                                    <td>{{ $subject->subject }}</td>
                                    <td>

                                    @include('confirm.strandsubdelete')
                                     </td>
                                   
                                </tr>
                                @php
                                    $subjectsFound = true;
                                @endphp
                            @endif
                        @endforeach

                        @if (!$subjectsFound)
                            <tr>
                                <td colspan="2">No subjects found for this grade level and semester.</td>
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
    
 @include('partials.script')


</script>
</body>
</html>
