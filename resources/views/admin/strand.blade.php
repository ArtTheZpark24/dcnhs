<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strand</title>
    @include('partials.css')
</head>
<body>

  @include('partials.navbar')
  


  <div class="wrapper">
    


    


     

@include('partials.maincontent')
      
    <!---- This is main content -->

 
      <div class="card mt-5">
  <div class="card-header bg-primary text-white">
    <span>Strands</span>
  </div>
  <div class="card-body">

    @include('add.strand')

    @include('partials.message')

 


  <div class="row">

  <div class="table-responsive">
    
      @if ($strands->count() > 0)
      <table class="table table-bordered" id="strandTable">

  
        <thead>
          <tr>
        
            <th scope="col">Strands List</th>
          
             <th scope="col">Action</th>
           
          </tr>
        </thead>
        <tbody>
      
        @foreach ($strands as $data )

      
        <tr>


        
        <td>{{ $data->strands }} ({{ $data->description }})</td>

        <td>

          <div class="d-flex">

          <a href="{{route('strand.class', ['strand'=> $data->strands, 'id' => $data->id])}}" class="fap"> <button class="btn btn-sm btn-primary mt-2 d-flex gap-2"> <i class="fa-solid fa-landmark mt-1"></i> Class</button></a>


      <a href="{{ route('strandsub.index', ['id'=>$data->id]) }}" class="btn" 
      data-bs-toggle="tooltip" data-bs-placement="top" title="Add subjects to {{ $data->strands }}"><button class="btn btn-sm btn-success d-flex gap-2"><i class="fa-solid fa-book mt-1"></i> Subjects</button></i></a>
       
        @include('edit.strand')
        @include('confirm.stranddelete')

        </td>

        </div>
  
      
          
          
          
          </tr>
        @endforeach
         <tbody>
        </tbody>
      </table>

      @else

      <p>No Strands Found</p>
    @endif
 

  </div>

  </div>

</div>

    
    </div>

     





  </div>
    
 @include('partials.script')


</script>
</body>
</html>
