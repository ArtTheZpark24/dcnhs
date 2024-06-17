<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classes</title>
    @include('partials.css')
</head>
<body>

  @include('studentpartials.navbar')
  


  <div class="wrapper">
    



@include('partials.maincontent')
      
<div class="card ">
    <div class="card-header bg-primary text-white" >
     Class(es)
    </div>
    <div class="card-body">
       
      <div class="table-responsive">
     
   @if($classes->count() > 0)

    <table class="table table-bordered" id="searchTable">

        <thead>
        <tr>
        <th>Subjects</th>
        <th>Day</th>
        <th>Time</th>
        <th>Teacher</th>
        </tr>
        </thead>
    <tbody>
 
  @foreach ($classes as $class )

  <tr>
    <td>{{$class->subject}}</td>
    <td>{{$class->day}}</td>
    <td>{{ date('h:i A', strtotime($class->time_start)) }} - {{ date('h:i A', strtotime($class->time_end)) }} </td>
    <td>{{$class->lastname}}, {{$class->firstname}} {{$class->initial}}. </td>

   
  </tr>
      
  @endforeach

    </tbody>
    </table>

    </div>
  </div>

  @else

  <p>No classes found</p>

  @endif





    
    </div>
  </div>
    
 @include('partials.script')


</script>
</body>
</html>
