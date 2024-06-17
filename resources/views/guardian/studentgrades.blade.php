<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student grades</title>
    @include('partials.css')
</head>
<body>

  @include('guardianpartial.navbar')
  


  <div class="wrapper">
    



@include('partials.maincontent')
      
<div class="card">
  <div class="card-body">
    <h5 class="mb-5 fw-bold">{{ $student->lastname }}, {{ $student->firstname }} {{ substr($student->middlename, 0, 1) }}.</h5>
  <table class="table table-bordered">
    <thead>
    <tr>
        <th>Grades</th>
        <th>Subject</th>
        <th>Semester</th>
        <th>Quarter</th>
        <th>Grade level</th>
        <th>Teacher</th>
    </tr>
    </thead>

    <tbody>
    @foreach ( $finalGrades as $grade )

    <tr>
    <td>{{$grade->final_grade}}</td>
    <td>{{$grade->subject}}</td>
    <td>{{$grade->semester}}</td>
    <td>{{$grade->quarter}}</td>
    <td>{{$grade->level}}</td>
    <td>{{$grade->lastname}}, {{$grade->firstname}} {{$grade->middlename}}</td>
    </tr>
        
    @endforeach
    </tbody>
  </table>
</div>





    
    </div>
  </div>
    
 @include('partials.script')


</script>
</body>
</html>
