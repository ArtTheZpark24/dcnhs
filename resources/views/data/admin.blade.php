<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create admin</title>
    @include('partials.css')
</head>
<body>

  @include('partials.navbar')
  


  <div class="wrapper">
    


    


     

@include('partials.maincontent')
      <div class="mt-4 address-menu">
            <span class="fw-light ">Home <span > <img src="{{ asset('icons/Vector.png') }}" alt=""> data</span> 
             <img src="{{ asset('icons/Vector.png') }}" alt=""> <span style="color: #2780C2"> Admin</span></span>
        </div>
<div class="card mt-3">
    <div class="card-header bg-primary text-white">
        <span>Admin List</span>
    </div>
    <div class="card-body">

        @include('partials.message')
      
     <div class="container mb-3">
              <div class="row">
                <div class="col-sm-4">
                  <form action="{{ route('admin.data') }}" method="GET" class="d-flex">
                    <input type="text" class="form-control me-2" name="query" placeholder="Search by name..." value="{{ request()->input('query') }}">

           
                    <button class="btn btn-primary btn-sm d-flex align-items-center gap-2" type="submit">
                      <i class="fa-solid fa-magnifying-glass"></i>
                      Search</button>
                  </form>
                </div>
              </div>
              
 
               <a href="{{ route('admin.create') }}" class="btn btn-primary btn-sm mb-3 mt-5">
              <i class="fa-solid fa-user-plus"></i> Add admin
            </a>
            </div>
           
           <div class="table-responsive">
        <table class="table table-bordered">

            <thead>
           
            <th>Admin names</th>
            <th>Email</th>
             <th>Role</th>
             <th>Action</th>
            </thead>

            <tbody>
            @foreach ( $admins as $admin )

            <tr>
         

            <td>{{$admin->name}}</td>
            <td>{{$admin->email}}</td>
             <td>{{$admin->is_admin == 1 ? 'Super admin' : 'Admin'}}</td>
             <td>

             @if (auth()->id() == $admin->id)

             <p>Authenticated</p>

              @else

              <div class="d-flex">
             @include('edit.admin')

             @include('confirm.admindelete')
              </div>

               
             @endif
                


            
             </td>
            </tr>
                
            @endforeach
            </tbody>
        </table>
        </div>
        <form action="{{route('admin.delete.all')}}" method="POST">

        @csrf

         
  </div>
</form>


  <div class="mt-3">
    {{ $admins->appends(request()->query())->links('pagination::bootstrap-5') }}
  
  
  </div>

 
    
    </div>
 
  </div>
    
 @include('partials.script')


</script>
</body>
</html>

<script>

   

</script>
