<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create teachers</title>
    @include('partials.css')
</head>
<body>

  @include('partials.navbar')
  


  <div class="wrapper">
    


    


     

@include('partials.maincontent')
      
     
<div class="mt-4 address-menu">
            <span class="fw-light ">Home <span > <img src="{{ asset('icons/Vector.png') }}" alt=""> Add</span> 
             <img src="{{ asset('icons/Vector.png') }}" alt=""> <span style="color: #2780C2"> Teachers</span></span>
        </div>


        <div class="card mt-4">
          <div class="card-header bg-primary text-white">
            Add Teacher
          </div>
          <div class="card-body shadow-sm">
            @include('partials.message')
            <h5 class="mt-3">Personal Information</h5>


      
           <form action="{{ route('teachers.create.post') }}" class="mt-5" method="POST">

           @csrf

            <div class="row">
            
              <div class="col-xs-3 col-sm-3 col-md-3 mt-3">
    <label for="teacher_id">Teacher ID*</label>
    <input type="number" class="form-control @error('teacher_id') is-invalid @enderror" id="teacher_id" name="teacher_id" placeholder="Teacher ID" value="{{ old('teacher_id') }}" required>
    @error('teacher_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
         </div>



              <div class="col-xs-3 col-sm-3 col-md-3 mt-3">
                <label for="lastname">Last name *</label>
               <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname" placeholder="Last name" value="{{ old('lastname') }}" required>
            @error('lastname')
        <div class="invalid-feedback">{{ $message }}</div>
                   @enderror
               </div>


               
               <div class="col-xs-3 col-sm-3 col-md-3 mt-3">
               <label for="firstname">First name *</label>
              <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname" placeholder="First name" value="{{ old('firstname') }}" required>
                            @error('firstname')
                  <div class="invalid-feedback">{{ $message }}</div>
                       @enderror
                 </div>


                 <div class="col-xs-3 col-sm-3 col-md-3 mt-3">
                  <label for="middlename">Middle name *</label>
                  <input type="text" class="form-control @error('middlename') is-invalid @enderror" id="middlename" name="middlename" placeholder="Middle name" value="{{ old('middlename') }}" required>
                  @error('middlename')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
               
            </div>

             <div class="row mt-3">
                <div class="col-xs-3 col-sm-3 col-md-3 mt-3">
    <label for="rank">Rank *</label>
    <select class="form-control @error('rank') is-invalid @enderror" id="rank" name="rank">
        <option value="Teacher I" {{ old('rank') == 'Teacher I' ? 'selected' : '' }}>Teacher I</option>
        <option value="Teacher II" {{ old('rank') == 'Teacher II' ? 'selected' : '' }}>Teacher II</option>
        <option value="Teacher III" {{ old('rank') == 'Teacher III' ? 'selected' : '' }}>Teacher III</option>
        <option value="Master Teacher I" {{ old('rank') == 'Master Teacher I' ? 'selected' : '' }}>Master Teacher I</option>
        <option value="Master Teacher II" {{ old('rank') == 'Master Teacher II' ? 'selected' : '' }}>Master Teacher II</option>
        <option value="Master Teacher III" {{ old('rank') == 'Master Teacher III' ? 'selected' : '' }}>Master Teacher III</option>
        <option value="Master Teacher IV" {{ old('rank') == 'Master Teacher IV' ? 'selected' : '' }}>Master Teacher IV</option>
    </select>
    @error('rank')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

             
  
<div class="col-xs-3 col-sm-3 col-md-3 mt-3">
    <label for="email">Email *</label>
    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email " value="{{ old('email') }}" required>
    @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
     </div>               








            <div class="col-xs-3 col-sm-3 col-md-3 mt-3">
                <label for="birth_place">Place of Birth </label>
                <input type="text" class="form-control @error('birth_place') is-invalid @enderror" id="birth_place" name="birth_place" placeholder="Place of Birth" value="{{ old('birth_place') }}" >
                @error('birth_place')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            


            

        
              
      <div class="col-xs-3 col-sm-3 col-md-3 mt-3">
        <label for="date_birth">Birth Date </label>
        <input type="date" class="form-control @error('date_birth') is-invalid @enderror" id="date_birth" name="date_birth" value="{{ old('date_birth') }}">
        @error('date_birth')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    

            



                 


          

             </div>



        
         <div class="row mt-3">

            <div class="col-xs-3 col-sm-3 col-md-3 mt-3">
                <label for="sex">Sex </label>
             <select class="form-control @error('sex') is-invalid @enderror" id="sex" name="sex">
           <option selected disabled>Select sex</option>
            <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
           
        </select>
        @error('sex')
            <div class="invalid-feedback">{{ $message }}</div>
         @enderror
                </div>



          <div class="col-xs-3 col-sm-3 col-md-3 mt-3">
    <label for="phone_number">Phone Number </label>
    <input type="number" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" placeholder="Phone Number" value="{{ old('phone_number') }}" >
    @error('phone_number')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
           </div>



        
         
  




        
         </div>

         <h5 class="mt-5">Address</h5>


         <div class="row mt-3">

          <div class="col-xs-3 col-sm-3 col-md-3 mt-3">
            <label for="street">Street </label>
            <input type="text" class="form-control @error('street') is-invalid @enderror" id="street" name="street" placeholder="Street" value="{{ old('street') }}">
            @error('street')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        


        
        <div class="col-xs-3 col-sm-3 col-md-3 mt-3">
          <label for="brgy">Barangay </label>
          <input type="text" class="form-control @error('brgy') is-invalid @enderror" id="brgy" name="brgy" placeholder="Barangay" value="{{ old('brgy') }}">
          @error('brgy')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
      </div>
      

    
    <div class="col-xs-3 col-sm-3 col-md-3 mt-3">
    <label for="city">City </label>
    <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" placeholder="City" value="{{ old('city') }}">
    @error('city')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


 <div class="col-xs-3 col-sm-3 col-md-3 mt-3">
    <label for="state">State </label>
    <input type="text" class="form-control @error('state') is-invalid @enderror" id="state" name="state" placeholder="State" value="{{ old('state') }}">
    @error('state')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


  




        
         </div>

          <button class="btn btn-primary mt-5">Submit</button>
        



          


            </div>
            
           </form>
        </div>



    
    </div>
  </div>
    
 @include('partials.script')


</script>
</body>
</html>
