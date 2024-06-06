<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardians Data</title>
    @include('partials.css')

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
</head>
<body>

    @include('partials.navbar')

    <div class="wrapper">
        @include('partials.maincontent')

        <div class="mt-4 address-menu">
            <span class="fw-light">Home <span style="color: #2780C2"><img src="{{ asset('icons/Vector.png') }}" alt=""> Guardians</span>
                <span style="color: #2780C2"><img src="{{ asset('icons/Vector.png') }}" alt=""> Data</span>
            </span>
        </div>

        <div class="card mt-4">
            <div class="card-header bg-primary text-white d-flex gap-5 justify-content-between align-items-center">
                <span>Guardian List</span>
                
            </div>
            <div class="card-body shadow-sm">
                @include('partials.message')

                <div class="container mb-3">
                      <div class="container mb-3">
              <div class="row">
                <div class="col-sm-4">
                  <form action="{{ route('guardians.data') }}" method="GET" class="d-flex">
                    <input type="text" class="form-control me-2" name="query" placeholder="Search by name..." value="{{ request()->input('query') }}">

           
                    <button class="btn btn-primary btn-sm d-flex align-items-center gap-2" type="submit">
                      <i class="fa-solid fa-magnifying-glass"></i>
                      Search</button>
                  </form>
                </div>
              </div>

              <div class="d-flex gap-2">
            

                    <a href="{{ route('guardians.create') }}" class="btn btn-primary btn-sm mb-3 mt-5">
                        <i class="fa-solid fa-user-plus"></i> Add guardian
                    </a>
                  

                      </div>
                      
                </div>

                @if ($datas->count() > 0)
                <div class="table-responsive" style="font-size: 14px;" >
                    <table class="table table-bordered" id="dataTable">
                        <thead>
                            <tr>
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
                                <th scope="col">State</th>
                                <th scope="col">Action</th>
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
                                <td>{{ $data->barangay == null ? 'N/A' : $data->barangay }}</td>
                                <td>{{ $data->city == null ? 'N/A' : $data->city }}</td>
                                <td>{{ $data->state == null ? 'N/A' : $data->state }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @include('edit.guardians')
                                        @include('confirm.guardiandelete')
                                        @include('confirm.guardianreset')
                                      
                                        <div>
                                            <a href="{{route('student.guardian.index', ['id' =>$data->id])}}" class="btn btn-sm btn-success gap-2 d-flex mt-2">
                                                <i class="fa-solid fa-graduation-cap mt-1"></i>Student
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $datas->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>

                @else
                <p>No guardians found found</p>
                @endif
            </div>
        </div>
    </div>

    @include('partials.script')

    
</body>
</html>
