<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grading</title>

    @include('partials.css')
</head>
<body>


@include('partials.navbar')

<div class="wrapper">

  
    @include('partials.maincontent')



    <div class="card mt-5">
        <div class="card-header bg-primary text-white d-flex gap-5 justify-content-between align-items-center">
            <span>Student Grade List</span>
        </div>
        <div class="card-body">
            <form id="filter-form">
                <div class="row">
                    <div class="col-md-2">
                        <input type="text" name="query" class="form-control" id="query" placeholder="Search by name or lrn">
                    </div>
                    <div class="col-md-2">
                        <select name="strand_id" class="form-control" id="search-strand">
                            <option disabled selected>Search by strand</option>
                            @foreach ($strands as $strand)
                                <option value="{{ $strand->id }}">{{ $strand->strands }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="grade_level_id" class="form-control" id="search-level">
                            <option disabled selected>Search by grade level</option>
                            @foreach ($levels as $level)
                                <option value="{{ $level->id }}">{{ $level->level }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="semester_id" class="form-control" id="search-semester">
                            @foreach ($semesters as $semester)
                                <option value="{{ $semester->id }}" {{ $semester->status == 'active' ? 'selected' : '' }}>
                                    {{ $semester->semester }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="school_year_id" class="form-control" id="school_year_id">
                            @foreach ($schoolYears as $year)
                                <option value="{{ $year->id }}" {{ $year->status == 2 ? 'selected' : '' }}>
                                    {{ $year->year_start }} - {{ $year->year_end }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="quarter" class="form-control" id="quarter">
                            <option disabled selected>Quarter</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                          
                        </select>
                    </div>
                </div>
            </form>

            
            @if ($errors->any())
    <div class="alert alert-danger mt-3">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif

            <div id="gradingTableContainer">
                @include('partials.grading')
               
            </div>
            {{ $finalGrades->appends(request()->query())->links('pagination::bootstrap-5') }}

            <div id="errorMessage" class="text-danger mt-2"></div>
        </div>
    </div>

    @include('partials.script')

    <script>
        $(document).ready(function() {
            $('#query, #search-strand, #search-level, #search-semester, #school_year_id, #quarter').on('change keyup', function() {
                liveSearch();
            });

            function liveSearch() {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('grading.index') }}",
                    data: $('#filter-form').serialize(),
                    success: function(data) {
                        $('#gradingTableContainer').html(data);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        $('#errorMessage').text("An error occurred: " + xhr.responseText);
                    }
                });
            }
        });
    </script>

    
    <script>
    
    </script>

</body>
</html>
