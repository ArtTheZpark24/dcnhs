<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $strand->strands }} {{ $level->level }}</title>
    @include('partials.css')
</head>
<body>

@include('partials.navbar')

<div class="wrapper">
    @include('partials.maincontent')

   
          @include('partials.message')
          @include('add.addstudsec')
           
      

     <div class="card mt-5">
        <div class="card-header bg-primary text-white">
          Student list of {{ $section->section_name }} section
        </div>
        <div class="card-body">

          @if($sectionStuds->count() > 0)

          <table class="table table-bordered">
          <thead>
          <tr>
          <th>Students</th>
          <th>Action</th>
          </tr>
          </thead>

          <tbody>
          
          @foreach ($sectionStuds  as $stud )
          <tr>
          <td> {{$stud->lastname}}, {{$stud->firstname}} {{$stud->middlename}}({{$stud->lrn}})</td>
          <td>
          @include('confirm.studsecdelete')
          </td>
          </tr>
              
          @endforeach
          
          </tbody>
          
          </table>

        

          @else

          <p>No student found</p>


          @endif



    
           
        </div>
    </div>
</div>

@include('partials.script')

</body>
</html>
