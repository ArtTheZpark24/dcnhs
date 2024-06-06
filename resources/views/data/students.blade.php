<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students Data</title>
    <style>
    .exportExcel {
    position: sticky;
    top: 0;
    background-color: white; 
    z-index: 1; 
    padding: 10px;
}
    </style>
    @include('partials.css')
</head>
<body>

  @include('partials.navbar')
  


  <div class="wrapper">
    


    


     

@include('partials.maincontent')
      
     
<div class="mt-4 address-menu">
            <span class="fw-light ">Home <span style="color: #2780C2"> <img src="{{ asset('icons/Vector.png') }}" alt=""> Student</span>
            <span style="color: #2780C2"> <img src="{{ asset('icons/Vector.png') }}" alt=""> Data
            </span>
        </div>


        <div class="card mt-4">
          <div class="card-header bg-primary text-white d-flex gap-5 justify-content-between align-items-center">
           <span>Student List</span>

            <div class="col-md-3">

       
         </div>

         
          </div>
          <div class="card-body shadow-sm ">

            
            <div class="container mb-3">
                <div class="row">
                  <div class="col-sm-4">
                    <form action="{{ route('students.data') }}" method="GET" class="d-flex">
                      <input type="text" class="form-control me-2" name="query" placeholder="Search by name..." value="{{ request()->input('query') }}">
  
             
                      <button class="btn btn-primary btn-sm d-flex align-items-center gap-2" type="submit">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        Search</button>
                    </form>
                  </div>
                </div>

            

            
         

            @include('partials.message')

         <a href="{{ route('students.create') }}" class="mb-3 btn btn-primary btn-sm mt-3"> <i class="fa-solid fa-user-plus"></i> Add new tudents</a>
         <br>

               
         @if ($datas->count() > 0)

        
         <div class="table-responsive" >
            <table class=" " style="font-size: 14px;" id="dataTable">

                <thead>
            <tr>
           
            <th scope="col">LRN</th>
            <th scope="col">Last name</th>
            <th scope="col">First name</th>
            <th scope="col">Middle name</th>
            <th scope="col">Email</th>
            <th scope="col">Sex</th>
            <th scope="col">Strand</th>
            <th scope="col">Place Birth</th>
            <th scope="col">Age</th>
            <th scope="col">Street</th>
            <th scope="col">Barangay</th>
            <th scope="col">City</th>
              <th scope="col">State</th>
            <th scope="col">Action</th>
            </tr>
            </thead>
            
            <tbody>
            @foreach ($datas as $data )
            
            
            <tr>
            
            
            
            <td>{{$data->lrn}}</td>
            <td>{{$data->lastname}}</td>
            <td>{{$data->firstname}}</td>
            <td>{{$data->middlename}}</td>
             <td>{{$data->email}}</td>
             <td>{{$data->sex}}</td>
            
               <td>{{$data->strand}} - {{$data->level}}</td>
               <td>{{$data->place_birth}}</td>
                       <?php
            
            $birthDate = new DateTime($data->date_birth);
            $currentDate = new DateTime();
            $age = $currentDate->diff($birthDate)->y;
                 ?>
               <td>{{$age}}</td>
               <td>{{$data->street == null ? 'N/A' : $data->street }}</td>
               <td>{{$data->brgy == null ? 'N/A' : $data->brgy }}</td>
               <td>{{$data->city == null ? 'N/A' : $data->city }}</td>
               <td>{{$data->state == null ? 'N/A' : $data->state }}</td>
               <td>
               <div class="d-flex gap-3">
               @include('edit.students')
               
               @include('confirm.studentdelete')
               @include('confirm.studenreset')
            
                 <div class="mt-2">
               <a class="btn btn-success btn-sm d-flex gap-2" href="{{route('admin.student.checklist', ['id' => $data->id])}}"><i class="fa-solid fa-list-check mt-1"></i> Checklist </a>
                </div>
               </div>
            
            
               
               
               </td>
            
                
                 
            
            </tr>
            
            @endforeach
            </tbody>
            
            </table>
         
 </div>

<div class="mt-3">
  {{ $datas->appends(request()->query())->links('pagination::bootstrap-5') }}

</div>
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




