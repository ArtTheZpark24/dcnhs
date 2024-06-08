<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Section</title>
    @include('partials.css')
</head>
<body>

  @include('partials.navbar')
  


  <div class="wrapper">
    


    


     

@include('partials.maincontent')
      


    <div class="card mt-5">
        <div class="card-header bg-primary text-white">
            Section List
        </div>
        <div class="card-body">
            @include('add.section')
            @include('partials.message')

            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>Sections</th>
                        <th>Strand</th>
                        <th>Grade Level</th>
                        <th>Adviser</th>
                         <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($sections as $section )

                <tr>

                <td>{{$section->section}}</td>
                <td>{{$section->strand}}</td>
                <td>{{$section->level}}</td>
                <td>{{$section->firstname}} {{ $section->lastname }}
                   ( {{$section->teacher_id}})
                </td>
               
                <td>
                    
                    <div class="d-flex">
                   <a  class="btn btn-success btn-sm d-flex gap-2 mt-2" style="height: 35px;" href="{{ route('section.student.index', ['strand_id'=> $section->strand_id, 'grade_level_id'=> $section->grade_level_id, 'section_id' => $section->id]) }}">
                   <i class="fa-solid fa-graduation-cap mt-1"></i> Student
                   </a>

                    @include('edit.section')
                   @include('confirm.sectiondelete')
        
         </div>

       
                </td>

                </tr>
                    
                @endforeach
                </tbody>
            </table>
    
        </div>
    
  </div>
    
 @include('partials.script')


</script>
</body>
</html>
