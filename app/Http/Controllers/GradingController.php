<?php

namespace App\Http\Controllers;

use App\Models\FinalGrade;
use App\Models\GradeLevel;
use App\Models\Guardian;
use App\Models\SchoolYear;
use App\Models\Semester;
use App\Models\Strand;
use App\Models\Student;
use App\Models\StudentGuardian;
use App\Notifications\GradePosted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GradingController extends Controller
{
    public function index(Request $request)
{
    $email = Auth::user()->email;

    $schoolYears = SchoolYear::select(
        DB::raw('YEAR(date_start) as year_start'),
        DB::raw('YEAR(date_end) as year_end'),
        'id',
        'status'
    )->get();

    $semesters = Semester::select('semester', 'id', 'status')->get();

    $levels = GradeLevel::select('level', 'id')->get();

    $strands = Strand::select('strands', 'id')->get();

    $datasQuery = FinalGrade::join('students', 'students.id', '=', 'final_grades.student_id')
        ->join('subjects', 'subjects.id', '=', 'final_grades.subject_id')
        ->join('strands', 'strands.id', '=', 'students.strand_id')
        ->join('teachers', 'teachers.id', '=', 'final_grades.teacher_id')
        ->join('semesters', 'semesters.id', '=', 'final_grades.semester_id')
        ->join('grade_levels', 'grade_levels.id', '=', 'final_grades.grade_level_id')
        ->join('school_years', 'school_years.id', '=', 'final_grades.school_year_id')
        ->select(
            'students.firstname as stud_firstname',
            'students.lastname as stud_lastname',
            DB::raw('SUBSTRING(students.middlename, 1, 1) as stud_middlename'),
            'final_grades.final_grade as final_grade',
            'teachers.firstname as teach_firstname',
            'teachers.lastname as teach_lastname',
            DB::raw('SUBSTRING(teachers.middlename, 1, 1) as teach_middlename'),
            'semesters.semester',
            'grade_levels.level as level',
            'strands.strands as strand',
            'subjects.subjects as subject',
            'final_grades.quarter as quarter',
            'final_grades.id as id',
            'final_grades.status as status',
            DB::raw('YEAR(school_years.date_start) as year_start'),
            DB::raw('YEAR(school_years.date_end) as year_end')
        )
        ->orderBy('students.lastname')
        ->orderBy('grade_levels.level')
        ->orderBy('semesters.semester');

    $query = $request->input('query');
    session()->flash('old_query', $query);

    if ($query) {
        $datasQuery->where(function($queryBuilder) use ($query) {
            $queryBuilder->where('students.lastname', 'LIKE', "%{$query}%")
                ->orWhere('students.middlename', 'LIKE', "%{$query}%")
                ->orWhere('students.firstname', 'LIKE', "%{$query}%")
                ->orWhere('students.email', 'LIKE', "%{$query}%")
                ->orWhere('students.lrn', 'LIKE', "%{$query}%")
                ->orWhereRaw("CONCAT(students.firstname, ' ', students.lastname, ' ', students.middlename) LIKE ?", ["%{$query}%"])
                ->orWhereRaw("CONCAT(students.lastname, ' ', students.firstname, ' ', students.middlename) LIKE ?", ["%{$query}%"])
                ->orWhereRaw("CONCAT(students.middlename, ' ', students.firstname, ' ', students.lastname) LIKE ?", ["%{$query}%"])
                ->orWhereRaw("CONCAT(students.firstname, ' ', students.middlename, ' ', students.lastname) LIKE ?", ["%{$query}%"])
                ->orWhereRaw("CONCAT(students.lastname, ' ', students.middlename, ' ', students.firstname) LIKE ?", ["%{$query}%"])
                ->orWhereRaw("CONCAT(students.middlename, ' ', students.lastname, ' ', students.firstname) LIKE ?", ["%{$query}%"]);
        });
    }

    if ($request->filled('strand_id')) {
        $datasQuery->where('students.strand_id', $request->input('strand_id'));
    }

    if ($request->filled('grade_level_id')) {
        $datasQuery->where('final_grades.grade_level_id', $request->input('grade_level_id'));
    }

    if ($request->filled('quarter')) {
        $datasQuery->where('final_grades.quarter', $request->input('quarter'));
    }

    if ($request->filled('semester_id')) {
        $datasQuery->where('final_grades.semester_id', $request->input('semester_id'));
    } else {
        $activeSemesterId = Semester::where('status', 'active')->value('id');
        $datasQuery->where('final_grades.semester_id', $activeSemesterId);
    }

    if ($request->filled('school_year_id')) {
        $datasQuery->where('final_grades.school_year_id', $request->input('school_year_id'));
    } else {
        $yearActive = SchoolYear::where('status', 2)->value('id');
        $datasQuery->where('final_grades.school_year_id', $yearActive);
    }

    $finalGrades = $datasQuery->paginate(10);

    if ($request->ajax()) {
        return view('partials.grading', compact('finalGrades'))->render();
    }

    return view('admin.grading', compact('email', 'finalGrades', 'schoolYears', 'semesters', 'levels', 'strands'));
}



    public function postGrades($id)
{
    $finalGrades = FinalGrade::find($id);

    if (!$finalGrades) {
        return view('error.error');
    }

    $student = Student::find($finalGrades->student_id);

     $guardians = StudentGuardian::where('student_id', $id)
                          ->join('guardians', 'guardians.id', '=', 'student_guardians.guardian_id')
                          ->select('guardians.id as id')
                           ->get();

    if (!$student) {
        return view('error.error');
    }



    $quarter = $finalGrades->quarter;

    $existingGrades = FinalGrade::where('student_id', $finalGrades->student_id)
                                ->where('quarter', $quarter)
                                ->where('status', 2)
                                ->where('subject_id', $finalGrades->subject_id)
                                ->first();

    if ($existingGrades) {
        return redirect()->back()->withErrors('Grades already posted');
    }

    $finalGrades->status = 2;
    $finalGrades->save();

     return redirect()->back()->with('success', 'Grade successfully posted');

 
    $student->notify(new GradePosted($finalGrades));
     foreach($guardians as $guardian){

                $guard = Guardian::find($guardian->id);
                $guard->notify(new GradePosted($finalGrades));


                }   

   
 

    return redirect()->back()->with('success', 'Grade successfully posted');
}


  public function postAllGrades(Request $request)
{
    
    $query = $request->input('query');
    $strandId = $request->input('strand_id');
    $gradeLevelId = $request->input('grade_level_id');
    $quarter = $request->input('quarter');
    $semesterId = $request->input('semester_id');
    $schoolYearId = $request->input('school_year_id');

   
    $gradesQuery = FinalGrade::join('students', 'students.id', '=', 'final_grades.student_id')
        ->join('semesters', 'semesters.id', '=', 'final_grades.semester_id')
        ->join('school_years', 'school_years.id', '=', 'final_grades.school_year_id')
        ->select('final_grades.*')
        ->orderBy('students.lastname')
        ->orderBy('final_grades.quarter');

    if ($query) {
        $gradesQuery->where(function($queryBuilder) use ($query) {
            $queryBuilder->where('students.lastname', 'LIKE', "%{$query}%")
                ->orWhere('students.middlename', 'LIKE', "%{$query}%")
                ->orWhere('students.firstname', 'LIKE', "%{$query}%")
                ->orWhere('students.email', 'LIKE', "%{$query}%")
                ->orWhere('students.lrn', 'LIKE', "%{$query}%")
                ->orWhereRaw("CONCAT(students.firstname, ' ', students.lastname, ' ', students.middlename) LIKE ?", ["%{$query}%"])
                ->orWhereRaw("CONCAT(students.lastname, ' ', students.firstname, ' ', students.middlename) LIKE ?", ["%{$query}%"])
                ->orWhereRaw("CONCAT(students.middlename, ' ', students.firstname, ' ', students.lastname) LIKE ?", ["%{$query}%"])
                ->orWhereRaw("CONCAT(students.firstname, ' ', students.middlename, ' ', students.lastname) LIKE ?", ["%{$query}%"])
                ->orWhereRaw("CONCAT(students.lastname, ' ', students.middlename, ' ', students.firstname) LIKE ?", ["%{$query}%"])
                ->orWhereRaw("CONCAT(students.middlename, ' ', students.lastname, ' ', students.firstname) LIKE ?", ["%{$query}%"]);
        });
    }

    if ($strandId) {
        $gradesQuery->where('students.strand_id', $strandId);
    }

    if ($gradeLevelId) {
        $gradesQuery->where('final_grades.grade_level_id', $gradeLevelId);
    }

    if ($quarter) {
        $gradesQuery->where('final_grades.quarter', $quarter);
    }

    if ($semesterId) {
        $gradesQuery->where('final_grades.semester_id', $semesterId);
    } else {
        $activeSemesterId = Semester::where('status', 'active')->value('id');
        $gradesQuery->where('final_grades.semester_id', $activeSemesterId);
    }

    if ($schoolYearId) {
        $gradesQuery->where('final_grades.school_year_id', $schoolYearId);
    } else {
        $yearActive = SchoolYear::where('status', 2)->value('id');
        $gradesQuery->where('final_grades.school_year_id', $yearActive);
    }


    $grades = $gradesQuery->get();


    foreach ($grades as $grade) {
        
        $existingGrades = FinalGrade::where('student_id', $grade->student_id)
                                     ->where('quarter', $grade->quarter)
                                     ->where('status', 2)
                                     ->first();
        if ($existingGrades) {
            continue; 
        }

       
        $grade->status = 2;
        $grade->save();

       
        $student = Student::find($grade->student_id);
        if ($student) {
            $student->notify(new GradePosted($grade));
        }

      
        $guardians = StudentGuardian::where('student_id', $grade->student_id)
                                    ->join('guardians', 'guardians.id', '=', 'student_guardians.guardian_id')
                                    ->select('guardians.id as id')
                                    ->get();

        foreach ($guardians as $guardian) {
            $guard = Guardian::find($guardian->id);
            if ($guard) {
                $guard->notify(new GradePosted($grade));
            }
        }
    }

    return redirect()->back()->with('success', 'All grades successfully posted');
}


    
    public function delete($id){

        $finalGrades = FinalGrade::find($id);

      

        $finalGrades->delete();

        return redirect()->back()->with('success', 'Grade deleted successfully');

      



    }

 

   

   




   
}
