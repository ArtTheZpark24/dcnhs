<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semester</title>
    @include('partials.css')
</head>
<body>

  @include('partials.navbar')
  


  <div class="wrapper">
    


    


     

@include('partials.maincontent')
      



<div class="card mt-5">
  <div class="card-header bg-primary text-white">
    Semester Status
  </div>
  <div class="card-body table-responsive">

    @include('partials.message')
   @if ($semesters->count() > 0)

   <table class="table table-bordered">

    <thead>
      <tr>
        <th>Semester</th>
        <th>Action</th>
      </tr>
    </thead>

    <tbody>
      @foreach ($semesters as $semester )
      <tr>
        <td >{{ $semester->semester }}</td>
       
        <td style="width: 200px;">
        
          <div class="d-flex">
            @if ($semester->status == 'active')
            @include('confirm.semesterdeac')
           
            @else
            @include('confirm.semesteractive')
            @endif

        
            
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
     @else 
     <p>No semesters found</p>
   @endif
</div>
  



    
    </div>
  </div>
    
 @include('partials.script')


</script>
</body>
</html>
