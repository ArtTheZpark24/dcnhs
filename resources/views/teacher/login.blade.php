<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

    <style>
    
    .school-bg {
    height: 100vh;
    flex-shrink: 0;
   background: url('../images/Vector-4.jpg') left/cover no-repeat;
    overflow: hidden;
    
}




.login-page{
   
height: 100vh;
flex-shrink: 0;
border-radius: var(--default, 0px);

background-color: #1e5d88;
display: flex;
align-items: center;
justify-content: center;
flex-direction: column;
}
.login-page > .form-container{
    width: 406px;
height: 372px;
flex-shrink: 0;
border-radius: 20px;
background: #FFF;
padding: 10px 20px ;
}
.login-page > .form-container form .login-input{
   
    display: block;
    margin: 0 auto;
    width: 348px;
    height: 50px;
    flex-shrink: 0;
    margin-top: 10px;
}
.login-page > .form-container form .btn-login{
    display: block;
    margin: 0 auto;
    width: 348px;
    height: 50px;
    flex-shrink: 0;
    border-radius: 10px;
background: var(--hello, #2780C2);
color: #FFF;
}

.login-page > .copy-right{
  color: var(--bg, #FCFCF7);
font-family: 'Poppins' sans-serif;
font-size: 14px;
font-style: normal;
font-weight: 700;
line-height: 150%; /* 21px */
letter-spacing: 0.07px;
margin-top: 32px;
}
    .form-container .error-border {
        
        border-color: red !important;
       
    }

@media screen and (max-width: 600px) {
    .school-bg {
        height: 100vh;
        flex-shrink: 0;
        background: 
       url('../images/Vector-4.jpg') left/cover no-repeat;
       overflow: hidden;
    
    }
   .login-page {
        padding: 20px;
        background-position: left; 
    }

    .login-page > .form-container {
        width: 100%;
        border-radius: 0;
    }

        .form-container .error-border {
        
        border-color: red !important;
    }


    .login-page > .form-container form .login-input,
    .login-page > .form-container form .btn-login {
        width: 100%;
    }
  
}


    </style>

</head>
<body>


   
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 school-bg" >
              
            </div>
            
            <div class="col-md-6 login-page">

                @include('partials.message')
                
              <div class="form-container">
                  
                  
          <form action="{{route('teacher.login')}}" method="POST" class="mt-5">

                        @csrf
                   
                    <input type="email" placeholder="Username" class="form-control login-input @error('email')
                        border-danger
                    @enderror" name="email" value="{{ old('email') }}"  required>
                  
                    <input type="password" placeholder="Password" class="form-control login-input @error('password')
                         border-danger
                    @enderror" name="password" required>
             
                    <br>
                     <label style="margin-left: 16px;" for="remember-me" class="mt-3 form-check">
                       <input  type="checkbox" class="form-check-input" name="remember-me" {{ old('remember-me') ? 'checked': '' }}> 
                       Remember me
                    </label>
                    <br>
                    <button class="form-control  btn-login fw-bold text-uppercase">Log in</button>
                    
                 
                   
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