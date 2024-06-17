<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Grades</title>
    <style>
    
    @media screen and (max-width: 600px){

      .excel-img{

      width: 250px;
      height: 100px;
    }

    }
    </style>
    @include('partials.css')
</head>
<body>

  @include('teacherpartials.navbar')
  

  <div class="wrapper">
    @include('partials.maincontent')
      
    <div class="card">
      <div class="card-body p-5">
        <h5>Import Grades in this format</h5>
        @if(Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
        </div>

        @else
            @include('partials.message')
    @endif
    
  
    

       <img class="excel-img" src="{{ asset('images/excel.jpg') }}" alt="" width="500px;" height="100px">
       <table id="gradesExport" class="table table-borderless" style="visibility: hidden">
    <thead>
        <tr>
            <th>LRN</th>
            <th>STUDENTS NAME</th>
            <th>INITIAL GRADE</th>
            <th>FINAL GRADE</th>
        </tr>
    </thead>
</table>


        <form action="{{ route('import.grades.post') }}" method="POST" enctype="multipart/form-data" class="mt-5  p-5">
          @csrf
          <div class="row">
            <div class="col-md-4">
            <label for="quarter_id">Quarter</label>
            <select name="quarter" id="quartet_id" class="form-control mb-3">
             <option value="1">Quarter 1</option>
             <option value="2">Quarter 2</option>
            </select>
              <label for="file">Import Excel</label>
              <input type="file" name="file" class="form-control mb-3" name="file">
            </div>

             <div class="col-md-4">
             <label for="subject_id">Subject</label>
            <select name="subject_id" id="subject_id" class="form-control mb-3">
              @if ($subjectClass->count() > 0)
              @foreach ($subjectClass as $subject )
              <option value="{{$subject->id}}">{{$subject->subject}}</option>
            @endforeach

            @else

             <option disabled selected>No subject found</option>
              @endif
          
            </select>
             
            </div>
          </div>
          <button type="submit" class="btn btn-primary mt-3">Submit</button>

          
        </form>

       
      </div>
    </div>
  </div>
    
 @include('partials.script')
</body>
</html>

