<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardians Archive</title>
    @include('partials.css')
</head>
<body>

  @include('partials.navbar')

  <div class="wrapper">
    @include('partials.maincontent')

    <div class="mt-4 address-menu">
      <span class="fw-light">Home <span style="color: #2780C2"> <img src="{{ asset('icons/Vector.png') }}" alt=""> Archive</span>
      <span style="color: #2780C2"> <img src="{{ asset('icons/Vector.png') }}" alt=""> Data</span>
    </div>

    <div class="card mt-4">
      <div class="card-header bg-primary text-white">
        <span>Guardian List</span>
      </div>
      <div class="card-body shadow-sm">

        <div class="container mb-3">
          <div class="row">
            <div class="col-sm-4">
              <form action="{{ route('guardians.archive') }}" method="GET" class="d-flex">
                <input type="text" class="form-control me-2" name="query" placeholder="Search by name..." value="{{ request()->input('query') }}">
                <button class="btn btn-primary btn-sm d-flex align-items-center gap-2" type="submit">
                  <i class="fa-solid fa-magnifying-glass"></i>
                  Search
                </button>
              </form>
            </div>
          </div>
        </div>

        @include('partials.message')

        @if(session('success'))
          <div class="alert alert-success mt-3">
            <p>{{ session('success') }}</p>
          </div>
        @endif

        @if($errors->any())
          <div class="alert alert-danger mt-3">
            <ul>
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        @if ($datas->count() > 0)
          
            @method('PATCH')
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Select All <br>
                      
                   
                    <th scope="col">Last name</th>
                    <th scope="col">First name</th>
                    <th scope="col">Middle name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone number</th>
                    <th scope="col">Sex</th>
                    <th scope="col">Place Birth</th>
                    <th scope="col">Age</th>
                    <th scope="col">Street</th>
                    <th scope="col">Barangay</th>
                    <th scope="col">City</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($datas as $data)
                    <tr>
                   
                      <td>{{ $data->lastname }}</td>
                      <td>{{ $data->firstname }}</td>
                      <td>{{ $data->middlename }}</td>
                      <td>{{ $data->email }}</td>
                      <td>{{ $data->phone }}</td>
                      <td>{{ $data->sex }}</td>
                      <td>{{ $data->place_of_birth }}</td>
                      <?php
                        $birthDate = new DateTime($data->birth_date);
                        $currentDate = new DateTime();
                        $age = $currentDate->diff($birthDate)->y;
                      ?>
                      <td>{{ $age }}</td>
                      <td>{{ $data->street == null ? 'N/A' : $data->street }}</td>
                      <td>{{ $data->brgy == null ? 'N/A' : $data->brgy }}</td>
                      <td>{{ $data->city == null ? 'N/A' : $data->city }}</td>
                      <td>
                        <div class="d-flex">
                    <form action="{{ route('guardians.restore', ['id' => $data->id]) }}" method="POST">
                      @csrf
                      @method('PATCH')
                      <button class="btn btn-warning btn-sm d-flex gap-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Restore">
                        <i class="fa-solid fa-arrow-rotate-left mt-1"></i> Restore
                      </button>
                    </form>
                  </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
      
        
        @else
          <p>No guardians found</p>
        @endif

        <div class="mt-3">
          {{ $datas->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
      </div>
    </div>
  </div>

  @include('partials.script')


  
</body>
</html>
