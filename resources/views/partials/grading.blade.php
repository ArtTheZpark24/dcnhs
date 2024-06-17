
<div id="gradingTableContainer" class="table-responsive" id="dataTable">


<table class="table table-bordered mt-3" >
    <thead>
        <tr>
         
            <th>Student name</th>
            <th>Strand</th>
            <th>Subject</th>
            <th>Quarter</th>
            <th>Semester</th>
            <th>Grade</th>
            <th>Teacher</th>
            <th>School Year</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($finalGrades as $grade)
        <tr>
       
            <td>{{ $grade->stud_lastname }}, {{ $grade->stud_firstname }} {{ $grade->stud_middlename }}.</td>
            <td>{{ $grade->strand }} - {{ $grade->level }}</td>
            <td>{{ $grade->subject }}</td>
            <td>{{$grade->quarter}}</td>
            <td>{{ $grade->semester }}</td>
            <td>{{ $grade->final_grade }}</td>
            <td>{{ $grade->teach_lastname }}, {{ $grade->teach_firstname }} {{ $grade->teach_middlename }}.</td>
            <td>{{ $grade->year_start }} - {{ $grade->year_end }}</td>
            <td>
                <div class="d-flex gap-2">
                    <form action="{{ route('grading.post', ['id' => $grade->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-primary btn-sm" {{ $grade->status == 2 ? 'disabled' : '' }}>
                            {{ $grade->status == 2 ? 'Posted' : 'Post' }}
                        </button>
                    </form>
                    <form action="{{ route('grading.delete', ['id' => $grade->id]) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this grade?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
   
</table>

<form action="{{ route('grading.all.post') }}" method="POST">
    @csrf

    <button type="submit" class="btn btn-primary btn-sm">Post all</button>
</form>




</div>