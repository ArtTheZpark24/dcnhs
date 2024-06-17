<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senior High School Class</title>
    @include('partials.css')
</head>
<body>

    @include('partials.navbar')

    <div class="wrapper">
        @include('partials.maincontent')
        @include('partials.message')
        <div class="card">
            <div class="card-header bg-primary text-white">
                Senior High School Class
            </div>
            <div class="card-body">
                <div class="container mb-3">
                    <div class="row">
                        <div class="col-sm-4">
                            <form action="{{ route('admin.school.classes') }}" method="GET" class="d-flex">
                                <input type="text" class="form-control me-2" name="query" placeholder="Search class..." value="{{ request()->input('query') }}">
                                <button class="btn btn-primary btn-sm d-flex align-items-center gap-2" type="submit">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    Search
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="table-responsive" >
                    @if($classes->count() > 0)
                        <table class="table table-bordered" id="searchTable">
                            <thead>
                                <tr>
                                    <th>Day</th>
                                    <th>Section</th>
                                    <th>Strand</th>
                                    <th>Subject</th>
                                    <th>Time</th>
                                    <th>Teacher</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($classes as $class)
                                    <tr>
                                        <td>{{ $class->day }}</td>
                                        <td>{{ $class->section }}</td>
                                        <td>{{ $class->strands }}</td>
                                        <td>{{ $class->subject }}</td>
                                        <td>{{ $class->time_start }} - {{ $class->time_end }}</td>
                                        <td>{{ $class->lastname }}, {{ $class->firstname }} {{ $class->initial }}.</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                @include('confirm.classdelete')
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No classes found</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('partials.script')

</body>
</html>
