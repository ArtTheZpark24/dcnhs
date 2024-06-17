<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subjects</title>
    @include('partials.css')
</head>
<body>

  @include('studentpartials.navbar')
  


  <div class="wrapper">
    



@include('partials.maincontent')
      
<div class="card">
    <div class="card-header text-white bg-primary" >
    Subjects enrolled
    </div>
    <div class="card-body">
 @if($subjects->count() > 0)

  <table class="table table-bordered">

    <thead>
    <tr>
    
 
    </tr>
    </thead>

    <tbody>
    @foreach ($subjects as $subject )

    <tr>
    <td>{{$subject->subject}}</td>
    </tr>
        
    @endforeach
    </tbody>

 </table>
 

 @else
 <p>No subject found</p>
 @endif
  </div>




    
    </div>
  </div>
    
 @include('partials.script')


</script>
</body>
</html>