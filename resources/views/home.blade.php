<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>City High Portal</title>
    @include('partials.css')
  
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
    .content {
        min-height: 100vh;
        background: url('../images/city-high-bg.jpg') left/cover no-repeat;
        background-size: cover; 
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{route('home.index')}}">
      <img src="{{ asset('images/logo.png') }}" alt="school-logo" class="school-logo">
      </a>
     

        <a href="{{ route('home.loginpage') }}" class="btn btn-primary">Login</a>
        
      
    </div>
  </nav>
  <div class="wrapper">
    <div class="content" id="main-content">
    <div class="container">
    <div class="card shadow-lg">
    <div class="card-body text-center">
      <h1 class="fw-bold">
        Welcome to DCNHS Portal
      </h1>
    </div>
    </div>
    </div>
    </div>
  </div>

  <!-- Include jQuery and Bootstrap 4 JavaScript -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  @include('partials.script')

</body>
</html>
