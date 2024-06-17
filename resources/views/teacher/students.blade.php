<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    @include('partials.css')
</head>
<body>

  @include('teacherpartials.navbar')
  


  <div class="wrapper">
    



@include('partials.maincontent')
      

   
<div class="card">
  <div class="card-header bg-primary text-white">
    {{$strand->strands}}  {{$level->level}}  {{$section->section_name}} ({{$subject->subjects}}) 
  </div>
  <div class="card-body table-responsive">
  
   
    @if($students->count() > 0)

    

      <table class="table table-bordered" id="searchTable">

        <thead>
        <tr>
        <th scope="col">LRN</th>
      <th scope="col">Last name</th>
      <th scope="col">First name</th>
      <th scope="col">Middle name</th>
      <th scope="col">Email</th>
      <th scope="col">Action</th>
        </tr>
        </thead>
    
    

      <tbody>
      @foreach ( $students as $student )
            <tr>
            <td>{{$student->lrn}}</td>
            <td>{{$student->firstname}}</td>
              <td>{{$student->lastname}}</td>
              <td>{{$student->middlename}}</td>
              <td>{{$student->email}}</td>
              <td><a href="{{ route('student.grades.compute', ['student_id'=> $student->id, 'subject_id' => $subject->id]) }}" class="btn btn-primary btn-sm">Grades</a></td>
            </tr>
        @endforeach
      </tbody>
      </table>

      

      @else
      <p>No student found</p>


    @endif
  </div>
</div>





    
  
  </div>
    
 @include('partials.script')


</script>
</body>
</html>


