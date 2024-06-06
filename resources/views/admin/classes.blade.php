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
      
  
        <div class="card mt-5">
            <div class="card-header bg-primary text-white">
             Classes of {{ $strand->strands }}
            </div>
            <div class="card-body">

                @include('add.class')
                @include('partials.message')

                @if($classes->count() > 0)


                
                <table class="table table-bordered">
                <thead>
                <th>Day</th>
                <th>Subjects</th>
                <th>Time</th>
                <th>Grade level</th>
                <th>Section</th>
                <th> Semester</th>
                <th>Teacher</th>
                <th>Action</th>
                </thead>

                <tbody>
                <tbody>

                    @foreach ($classes as $class )

                    <tr>
                        <td>{{$class->day}}</td>
                    <td>{{$class->subject}}</td>
                    <td>{{ date('h:i A', strtotime($class->time_start)) }} - {{ date('h:i A', strtotime($class->time_end)) }}</td>
                    <td>Grade {{ $class->level }} </td>
                    <td>{{$class->section}}</td>
                     <td>{{$class->semester}}</td>
                    <td>{{$class->firstname}} {{$class->lastname}}</td>
                        <td>
                          <div class="d-flex">
                            
                            @include('edit.classes')
                            @include('confirm.classdelete')
                          
                            </td>
                            </div>
                    </tr>

                
                        
                    @endforeach
                </tbody>
                
                </tbody>
                </table>

                @else

                <p>No classes found on this strand</p>

                @endif

             
          </div>
 
</div>





    
    </div>
    
  </div>
    
 @include('partials.script')


</script>
</body>
</html>
