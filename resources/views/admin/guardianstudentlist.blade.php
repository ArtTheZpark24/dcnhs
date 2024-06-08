<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of student</title>
    @include('partials.css')
</head>
<body>

  @include('partials.navbar')
  


  <div class="wrapper">
    


   

     

@include('partials.maincontent')
      
  

     
<div class="card">
    <div class="card-body">

        
    @include('partials.message')

      <a href="{{route('student.guardian.index', ['id' =>$guardian->id])}}" class="btn btn-sm btn-success gap-2 d-flex mt-2 mb-5" style="width: 150px;">
                                                <i class="fa-solid fa-graduation-cap mt-1"></i> Add Student
                                            </a>

        <h5 class="mb-3">{{$guardian->firstname}} {{ $guardian->lastname }} student(s)</h5>

        <table class="table table-bordered">
        <thead>
        <tr>
        <th>Student(s)</th>
        <th>Action</th>
        </tr>
        </thead>

        <tbody>

        @foreach ($guardianStuds as $stud )

        <tr>
        
        <td>{{$stud->lastname}}, {{ $stud->firstname }} {{ $stud->middle_initial }}.</td>
        <td>
         @include('confirm.studenguardiandelete')

        
    @endforeach
        
        </tbody>
        
        </table>
    
    </div>
</div>

       

      
      
 
    



    
    </div>
  </div>
    
 @include('partials.script')


</script>
</body>
</html>




