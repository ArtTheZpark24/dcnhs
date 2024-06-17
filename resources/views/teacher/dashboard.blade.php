<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @include('partials.css')
</head>
<body>

  @include('teacherpartials.navbar')
  


  <div class="wrapper">
    



@include('partials.maincontent')
      
<div class="card">
<div class="card-body p-5">
 
  <div class="row widgets">
    <div class="col-md-3 widgets-item">
    <h4 class="navbar-brand text-uppercase widgets-title">
     Classes
    </h4>

    <span class="widgets-count ">
    {{$classes}}
    </span>
    </div>

        <div class="col-md-3 widgets-item">
    <h4 class="navbar-brand text-uppercase widgets-title">
     Advisories
    </h4>

    <span class="widgets-count ">
    {{$advisory}}
    </span>
    </div>


@foreach ($subjects as $subject )

 <div class="col-md-3 widgets-item">
    <h5>
    {{$subject->subject}}

<em style="font-size: 10px;">
    {{ \Carbon\Carbon::parse($subject->time_start)->format('g:i A') }} - {{ \Carbon\Carbon::parse($subject->time_end)->format('g:i A') }}
</em>


  
    </h5>

  

    
    </div>

  
@endforeach
    
    
    
</div> 


</div>
</div>
  </div>
    
 @include('partials.script')


</script>
</body>
</html>
