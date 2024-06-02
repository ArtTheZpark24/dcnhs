<a href="#edit{{ $data->id }}" class="btn" data-bs-toggle="modal" data-bs-target="#edit{{ $data->id }}">
    <button class="btn btn-warning btn-sm d-flex gap-2"><i class="fa-solid fa-pencil mt-1"></i> Edit</button>
  </a>
  
  <div class="modal fade" id="edit{{ $data->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">Edit {{ $data->firstname }} {{ $data->lastname }} ({{ $data->teacher_id }})</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('teachers.data.update', ['id' => $data->id]) }}" class="mt-5" method="POST">
                    @csrf
                    @method('PUT')
  
                    <div class="row">
                        <div class="col-md-3 mt-3">
                            <label for="teacher_id">Teacher ID*</label>
                            <input type="text" class="form-control @error('teacher_id') is-invalid @enderror" id="teacher_id" name="teacher_id" placeholder="Teacher ID" value="{{ $data->teacher_id }}" required>
                            @error('teacher_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
  
                        <div class="col-md-3 mt-3">
                            <label for="lastname">Last name *</label>
                            <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname" placeholder="Last name" value="{{ $data->lastname }}" required>
                            @error('lastname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
  
                        <div class="col-md-3 mt-3">
                            <label for="firstname">First name *</label>
                            <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname" placeholder="First name" value="{{ $data->firstname }}" required>
                            @error('firstname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
  
                        <div class="col-md-3 mt-3">
                            <label for="middlename">Middle name *</label>
                            <input type="text" class="form-control @error('middlename') is-invalid @enderror" id="middlename" name="middlename" placeholder="Middle name" value="{{ $data->middlename }}" required>
                            @error('middlename')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
  
                    <div class="row mt-3">
                        <div class="col-md-3 mt-3">
                            <label for="rank">Rank *</label>
                            <select class="form-control @error('rank') is-invalid @enderror" id="rank" name="rank">
                                <option value="Teacher I" {{ $data->rank == 'Teacher I' ? 'selected' : '' }}>Teacher I</option>
                                <option value="Teacher II" {{ $data->rank == 'Teacher II' ? 'selected' : '' }}>Teacher II</option>
                                <option value="Teacher III" {{ $data->rank == 'Teacher III' ? 'selected' : '' }}>Teacher III</option>
                                <option value="Master Teacher I" {{ $data->rank == 'Master Teacher I' ? 'selected' : '' }}>Master Teacher I</option>
                                <option value="Master Teacher II" {{ $data->rank == 'Master Teacher II' ? 'selected' : '' }}>Master Teacher II</option>
                                <option value="Master Teacher III" {{ $data->rank == 'Master Teacher III' ? 'selected' : '' }}>Master Teacher III</option>
                                <option value="Master Teacher IV" {{ $data->rank == 'Master Teacher IV' ? 'selected' : '' }}>Master Teacher IV</option>
                            </select>
                            @error('rank')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
  
                        <div class="col-md-3 mt-3">
                            <label for="sex">Sex *</label>
                            <select class="form-control @error('sex') is-invalid @enderror" id="sex" name="sex">
                                <option value="Male" {{ $data->sex == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ $data->sex == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('sex')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
  
                        <div class="col-md-3 mt-3">
                            <label for="birth_place">Place of Birth *</label>
                            <input type="text" class="form-control @error('birth_place') is-invalid @enderror" id="birth_place" name="birth_place" placeholder="Place of Birth" value="{{ $data->birth_place }}" required>
                            @error('birth_place')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
  
                        <div class="col-md-3 mt-3">
                            <label for="date_birth">Birth Date *</label>
                            <input type="date" class="form-control @error('date_birth') is-invalid @enderror" id="date_birth" name="date_birth" value="{{ $data->date_birth }}">
                            @error('date_birth')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
  
                    <div class="row mt-3">
                        <div class="col-md-3 mt-3">
                            <label for="email">Email *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email Address" value="{{ $data->email }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
  
                        <div class="col-md-3 mt-3">
                            <label for="phone_number">Phone Number *</label>
                            <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" placeholder="Phone Number" value="{{ $data->phone_number }}" >
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
  
                    <h5 class="mt-5">Address</h5>
  
                    <div class="row mt-3 mb-3">
                        <div class="col-md-3 mt-3">
                            <label for="street">Street </label>
                            <input type="text" class="form-control @error('street') is-invalid @enderror" id="street" name="street" placeholder="Street" value="{{ $data->street }}">
                            @error('street')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
  
                        <div class="col-md-3 mt-3">
                            <label for="brgy">Barangay *</label>
                            <input type="text" class="form-control @error('brgy') is-invalid @enderror" id="brgy" name="brgy" placeholder="Barangay" value="{{ $data->brgy }}">
                            @error('brgy')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
  
                        <div class="col-md-3 mt-3">
                            <label for="city">City *</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" placeholder="City" value="{{ $data->city }}">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-xs-3 col-sm-3 col-md-3 mt-3">
                            <label for="state">State *</label>
                            <input type="text" class="form-control @error('state') is-invalid @enderror" id="state" name="state" placeholder="State" value="{{ $data->state }}">
                            @error('state')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                    </div>
  
                    <div class="modal-footer mt-5">
                        <button type="button" class="btn btn-secondary mt-5" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary mt-5">Save changes</button>
                    </div>
                    </form>
            </div>
        </div>
    </div>
  </div>
  