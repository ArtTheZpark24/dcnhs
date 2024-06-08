<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add student</title>
    @include('partials.css')
</head>
<body>

@include('partials.navbar')

<div class="wrapper">
    @include('partials.maincontent')

    <div class="card">
        <div class="card-header bg-primary text-white">
            Add student {{ $guardian->firstname }} {{ $guardian->lastname }}
        </div>
        <div class="card-body p-5">
         
         

            @include('partials.message')

            <form action="{{ route('student.guardian.create', ['id' => $guardian->id]) }}" method="POST">
                @csrf
                <div class="row">
                    @if($students->count() > 0)
                        <table class="table" id="searchTable">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr>
                                        <td>
                                            <div class="form-check mb-3">
                                                <input type="checkbox" class="form-check-input"
                                                       id="student_{{ $student->id }}" name="student_id[]" value="{{ $student->id }}"
                                                    {{ in_array($student->id, $guardianStuds->pluck('student_id')->toArray()) ? 'disabled' : '' }}>
                                                <label class="form-check-label" for="student_{{ $student->id }}">
                                                    {{ $student->lastname }}, {{ $student->firstname }} {{ $student->middle_initial }} ({{ $student->lrn }})
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No student found</p>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

@include('partials.script')

</body>
</html>
