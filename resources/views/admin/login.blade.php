<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png')}}">

</head>
<body>


   
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 school-bg" >
              
            </div>
            
            <div class="col-md-6 login-page">

                @include('partials.message')
                
              <div class="form-container">
                  
                  
          <form action="{{ route('admin-post') }}" method="POST" class="mt-5">

                        @csrf
                   
                    <input type="email" placeholder="Username" class="form-control login-input @error('email')
                        border-danger
                    @enderror" name="email" value="{{ old('email') }}"  required>
                  
                    <input type="password" placeholder="Password" class="form-control login-input @error('password')
                         border-danger
                    @enderror" name="password" required>

                     <label style="margin-left: 16px;" for="remember-me" class="mt-3 form-check">
                       <input  type="checkbox" class="form-check-input" name="remember-me" {{ old('remember-me') ? 'checked': '' }}> 
                       Remember me
                    </label>
                    

                     


                  
             
                    <br>
                    <button class="form-control btn-login fw-bold text-uppercase">Log in</button>
                    
                       


                 
                    <p class="text-center fw-light mt-3 forgot-password"><a class="nav-link" href="{{ route('forgot.password') }}">Forgot password?</a></p>
                   
                </form>

                </div>
                 <p class="copy-right">Copyright 2024 MEDI. All right reserved</p>
                 

              

  

                 

               
                

                  

                
                
               
            

            </div>
            
        </div>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</html>