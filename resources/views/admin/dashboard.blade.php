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
      
   <div class="row widgets">
         <div class="col-md-3 widgets-item" class="">
         <h4 class="navbar-brand text-uppercase widgets-title">
     
          Total Students
         </h4>

        

         <span class="widgets-count ">
             
         {{$totalStudents}}
         </span>

         
         </div>

         <div class="col-md-3 widgets-item">
          <h4 class="navbar-brand text-uppercase widgets-title">
          Total Teachers
         </h4>

         <span class="widgets-count ">
        {{$totalTeachers}}
         
         </div>
         <div class="col-md-3 widgets-item">
          <h4 class="navbar-brand text-uppercase widgets-title">
          Guardians
         </h4>

         <span class="widgets-count ">
        {{$totalParents}}
         </div>
         <div class="col-md-3 widgets-item">
          <h4 class="navbar-brand text-uppercase widgets-title">
          Resigned Teachers
         </h4>

         <span class="widgets-count ">
         {{$resignedTeachers}}
         
         </div>
     </div> 


     


     
     <div class="container-fluid mt-5">
      <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4"></div>
      <div class="col-md-4">
      <div id="piechart" style="width: 400px; height: 300px;"></div>
      </div>
      </div>
    </div>
       

      
      
 
    



    
    </div>
  </div>
    
 @include('partials.script')


</script>
</body>
</html>
<script>

  
</script>


<<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
      backgroundColor: '#f5f5f5',
      chartArea: {top: '30%', width: '80%', height: '80%' }, // Adjusted chart area size
      slices: {
        0: {color: 'blue'},   
        1: {color: '#eb2f7f'}    
      },
      fontSize: 12, // Adjust font size
      legend: { textStyle: { fontSize: 12 } } // Adjust legend font size
    };

    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

    chart.draw(data, options);
  }
</script>
</script>

