<nav class="navbar shadow-lg top-bar navbar-expand-lg navbar-light bg-light">
  <div>
    <i class="fa-solid fa-bars" style="cursor: pointer; margin-left: 20px;" 
    data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
    </i>
    <img src="{{ asset('images/logo.png') }}" alt="school-logo" class="school-logo">
  </div>
  <form action="{{route('admin-logout')}}" method="POST" >
  @csrf
    <button class="btn" style="margin-right: 16px" data-bs-toggle="tooltip" data-bs-placement="right" title="logout">
      <i class="fa-solid fa-power-off"></i>
      </button>

      </form>
</nav>

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel" style="width: 250px;">
  <div class="d-flex">
    <button type="button" class="btn btn-text-reset text-reset " data-bs-dismiss="offcanvas" aria-label="Close">
      <i class="fa-solid fa-bars w-25"></i>
    </button>
<span style="font-size: 12px;" class="mt-2">{{ $email }}</span>
   
  </div>
  <div class="offcanvas-body ">
    <div>
    </div>
    <div class="dropdown mt-3">
      <ul class="item">

        
       
        <li class="side-item"><a href="{{ route('admin.dashboard') }}" class="active-link"><i class="fa-solid fa-gauge"></i> <span>Dashboard</span></a></li>
        <li class="accordion-button collapsed side-item" type="button" data-bs-toggle="collapse" data-bs-target="#allData" aria-expanded="false" aria-controls="flush-collapseTwo">
          <a href="#"><i class="fa-solid fa-user-plus"></i> <span>Add data</span></a>
        </li>
        <ul id="allData" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
          @if(auth()->check() && auth()->user()->is_admin == 1)
     <li class="side-item"><a href="{{ route('admin.data') }}"><i class="fa-solid fa-user-tie"></i><span>Admin</span></a></li>


     @endif

          <li class="side-item"><a href="{{route('teachers.data')}}"><i class="fa-solid fa-chalkboard-user"></i> <span>Teachers</span></a></li>
          <li class="side-item"> <a href="{{ route('students.data') }}"><i class="fa-solid fa-graduation-cap"></i> <span>Student</span></a></li>
          <li class="side-item"> <a href="{{route('guardians.data')}}"><i class="fa-solid fa-person-breastfeeding"></i> <span>Guardian</span></a></li>
        </ul>
      <li class="side-item"><a href="{{route('all.users')}}"><i class="fa-solid fa-users"></i> <span>All Users</span></a></li>
       
           <!-- data list -->
         
       
        <li class="side-item"><a href="{{route('strand.index')}}"><i class="fa-solid fa-landmark"></i> <span>Strand</span></a></li>
          <li class="side-item"><a href="{{route('admin.school.classes')}}"><i class="fa-solid fa-school"></i><span> Class</span></a></li>
        <li class="side-item"><a href="{{route('subject.index')}}"><i class="fa-solid fa-book"></i> <span>Subject</span></a></li>
        <li class="side-item"><a href="{{ route('section.index') }}"><i class="fa-solid fa-layer-group"></i> <span>Section</span></a></li>
        <li class="side-item"><a href="{{route('school.year')}}"><i class="fa-solid fa-calendar"></i></i> <span>School year</span></a></li>
        <li class="side-item"><a href="{{ route('semester') }}"><i class="fa-solid fa-calendar-check"></i> <span>Semester</span></a></li>
        <li class="side-item"><a href="{{route('grading.index')}}"><i class="fa-solid fa-table"></i> <span>Student Grades</span></a></li>
        <li class="side-item"><a href="{{route('students.graduates')}}"><i class="fa-solid fa-graduation-cap"></i> <span>Students Grad</span></a></li>
         <!-- archive -->
         <li class="accordion-button collapsed side-item" type="button" data-bs-toggle="collapse" data-bs-target="#allTrash" aria-expanded="false" aria-controls="flush-collapseTwo">
          <a href="#"><i class="fa-solid fa-trash"></i> <span>Trash</span></a>
        </li>

        <ul id="allTrash" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">

          @if(auth()->check() && auth()->user()->is_admin == 1)
       <li class="side-item"><a href="{{ route('admin.archive') }}"><i class="fa-solid fa-user-tie"></i><span>Admin</span></a></li>
       @endif
          <li class="side-item"><a href="{{route('teachers.data.archive')}}"><i class="fa-solid fa-chalkboard-user"></i> <span>Teachers</span></a></li>
          <li class="side-item"> <a href="{{ route('students.data.archive') }}"><i class="fa-solid fa-graduation-cap"></i> <span>Student</span></a></li>
          <li class="side-item"> <a href="{{route('guardians.archive')}}"><i class="fa-solid fa-person-breastfeeding"></i> <span>Guardian</span></a></li>
        </ul>


       
        <hr>
        <li class="side-item"><a href="{{route('admin.profile')}}"><i class="fa-solid fa-user"></i> <span>Profile</span></a></li>
        
      </ul>
    </div>
  </div>

</div>

<style>
  .offcanvass-logo {
    width: 50px;
    height: 50px;
  }

  .offcanvas-header {
    gap: 16px;
  }

  .btn-text-reset {
    margin-left: 10px;
  }

  .offcanvas {
    padding: 5px 10px;
  }

  .item {
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  .item .side-item {
    list-style: none;
    cursor: pointer;
    
  }

  .item .side-item:hover {
    background-color: #f7f7fc;
  }

  .item .side-item a {
    gap: 16px;
    align-items: center;
    font-family: 'Poppins', sans-serif;
    text-decoration: none;
    color: #141414;
    font-size: 14px;
  
  }


  .item .side-item a span {
    font-weight: 500;
    font-family: 'Poppins', sans-serif;
    
  }

  /* Style accordion button */
  .accordion-button {
    border: none;
    background: none;
    padding: 0;
    cursor: pointer;
  }
  
</style>