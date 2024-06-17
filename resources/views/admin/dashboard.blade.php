<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @include('partials.css')
</head>
<body>

  @include('partials.navbar')
  
  <div class="wrapper">
    @include('partials.maincontent')

    <div class="card">
      <div class="card-body p-3">
        <div class="row widgets mt-5">
          <div class="col-md-3 widgets-item">
            <h4 class="navbar-brand text-uppercase widgets-title">Total Students</h4>
            <span class="widgets-count ">{{$totalStudents}}</span>
          </div>
          <div class="col-md-3 widgets-item">
            <h4 class="navbar-brand text-uppercase widgets-title">Total Teachers</h4>
            <span class="widgets-count ">{{$totalTeachers}}</span>
          </div>
          <div class="col-md-3 widgets-item">
            <h4 class="navbar-brand text-uppercase widgets-title">Guardians</h4>
            <span class="widgets-count ">{{$totalParents}}</span>
          </div>
          <div class="col-md-3 widgets-item">
            <h4 class="navbar-brand text-uppercase widgets-title">Resigned Teachers</h4>
            <span class="widgets-count ">{{$resignedTeachers}}</span>
          </div>
        </div>

        <h5 class="mt-5 fw-bold">Achievers</h5>
        
        <div class="row mb-3">
          <div class="col-md-3">
         
            <form action="{{ route('admin.dashboard') }}" method="GET" id="filterForm">
               <label for="semester_id">Semester</label>
              <select name="semester_id" id="semester_id" class="form-control">
                @foreach ($semesters as $semester)
                  <option value="{{ $semester->id }}" {{ $semester->status == 'active' ? 'selected' : '' }}>
                    {{ $semester->semester }}
                  </option>
                @endforeach
              </select>
          </div>
          <div class="col-md-3">
          <label for="school_year_id">S.Y.</label>
            <select id="school_year_id" name="school_year_id" class="form-control">
              @foreach ($schoolYears as $year)
                <option value="{{$year->id}}" {{$year->status == 2 ? 'selected' : ''}}>
                  {{$year->year_start}} - {{$year->year_end}}
                </option>
              @endforeach
            </select>
        
         
          </div>

           <div class="col-md-3">
           <label for="strand_id">Strands</label>
            <select id="strand_id" name="strand_id" class="form-control">
            <option disabled selected>Select strand</option>
              @foreach ($strands as $strand)
                <option value="{{$strand->id}}">
                {{$strand->strands}}({{$strand->description}})
                 
                </option>
              @endforeach
            </select>
        
          
          </div>


          <div class="col-md-3">
           <label for="level_id">Level</label>
            <select id="level_id" name="level_id" class="form-control">
            <option disabled selected>Select strand</option>
              @foreach ($levels as $level)
                <option value="{{$level->id}}">
                {{$level->level}}
                 
                </option>
              @endforeach
            </select>
        
          
          </div>


            </form>
        </div>

        <div class="table-responsive" id="tableContainer">
          @include('partials.achievers')
        </div>

          <div class="container-fluid mt-5">
      <div class="row">
      <div class="col-md-4">
      <div id="piechart" style="width: 50px px; height: 170px;"></div>
      </div>
      <div class="col-md-4">
       
      </div>
      <div class="col-md-4">
     
      </div>
      </div>
    </div>
      </div>
    </div>
    
    <div id="errorMessage" class="text-danger mt-2"></div>
  </div>
  
  @include('partials.script')

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Gender', 'Count'],
        ['Male', {{ $studentMale }}],
        ['Female', {{ $studentFemale }}]
      ]);

      var options = {
        title: 'Student Composition',
        backgroundColor: '#fff',
        chartArea: {top: '30%', width: '80%', height: '80%' }, 
        slices: {
          0: {color: 'blue'},   
          1: {color: '#eb2f7f'}    
        },
        fontSize: 12, 
        legend: { textStyle: { fontSize: 12 } } 
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart'));

      chart.draw(data, options);
    }
  </script>

  <script>
$(document).ready(function(){
  $('#semester_id, #school_year_id, #strand_id, #level_id').on('change', function(){
    liveSearch();
  });

  function liveSearch(){
   console.log($('#filterForm').serialize()); 
    $.ajax({
      type: "GET",
      url: "{{ route('admin.dashboard') }}",
      data: $('#filterForm').serialize(),
      success: function(data) {
        $('#tableContainer').html(data);
      },
      error: function(xhr) {
        console.error(xhr.responseText);
        $('#errorMessage').text("An error occurred: " + xhr.responseText);
      }
    });
  }
});

  </script>
</body>
</html>
