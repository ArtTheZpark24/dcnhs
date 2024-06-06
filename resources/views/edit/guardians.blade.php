<a type="#edit{{ $data->id }}" class="btn" data-bs-toggle="modal" data-bs-target="#edit{{ $data->id }}">
    <button class="btn btn-warning btn-sm d-flex gap-2"><i class="fa-solid fa-pencil mt-1"></i> Edit</button>
</a>

<div class="modal fade" id="edit{{ $data->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">Edit {{ $data->firstname }} {{ $data->lastname }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('partials.message')
                <form action="{{ route('guardians.update', ['id' => $data->id]) }}" class="mt-5" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3 mt-3">
                            <label for="lastname">Last name *</label>
                            <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname" placeholder="Last name" value="{{$data->lastname}}" required>
                            @error('lastname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-xs-3 col-sm-3 col-md-3 mt-3">
                            <label for="firstname">First name *</label>
                            <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname" placeholder="First name" value="{{ $data->firstname }}" required>
                            @error('firstname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-xs-3 col-sm-3 col-md-3 mt-3">
                            <label for="middlename">Middle name *</label>
                            <input type="text" class="form-control @error('middlename') is-invalid @enderror" id="middlename" name="middlename" placeholder="Middle name" value="{{ $data->middlename }}" required>
                            @error('middlename')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-xs-3 col-sm-3 col-md-3 mt-3">
                            <label for="occupation">Occupation *</label>
                            <input type="text" class="form-control @error('occupation') is-invalid @enderror" id="occupation" name="occupation" placeholder="Occupation" value="{{ $data->occupation}}" >
                            @error('occupation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-xs-3 col-sm-3 col-md-3 mt-3">
                            <label for="sex">Sex *</label>
                            <select class="form-control @error('sex') is-invalid @enderror" id="sex" name="sex">
                                <option value="Male" {{ $data->sex == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ $data->sex  == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('sex')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-xs-3 col-sm-3 col-md-3 mt-3">
                            <label for="place_of_birth">Place of Birth *</label>
                            <input type="text" class="form-control @error('place_of_birth') is-invalid @enderror" id="place_of_birth" name="place_of_birth" placeholder="Place of Birth" value="{{ $data->place_of_birth }}" >
                            @error('place_of_birth')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-xs-3 col-sm-3 col-md-3 mt-3">
                            <label for="birth_date">Date of Birth *</label>
                            <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" name="birth_date" value="{{ $data->birth_date }}" >
                            @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-xs-3 col-sm-3 col-md-3 mt-3">
                            <label for="email">Email *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" value="{{ $data->email }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-xs-3 col-sm-3 col-md-3 mt-3">
                            <label for="phone">Phone *</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Phone" value="{{ $data->phone }}" >
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <h5 class="mt-5">Address</h5>

                    <div class="row mt-3">
                        <div class="col-xs-3 col-sm-3 col-md-3 mt-3">
                            <label for="street">Street </label>
                            <input type="text" class="form-control @error('street') is-invalid @enderror" id="street" name="street" placeholder="Street" value="{{ $data->street }}">
                            @error('street')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-xs-3 col-sm-3 col-md-3 mt-3">
                            <label for="barangay">Barangay *</label>
                            <input type="text" class="form-control @error('barangay') is-invalid @enderror" id="barangay" name="barangay" placeholder="Barangay" value="{{ $data->barangay }}">
                            @error('barangay')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        

                        <div class="col-xs-3 col-sm-3 col-md-3 mt-3">
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

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                       
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
