<?php

namespace App\Http\Controllers;

use App\Models\GradeLevel;
use App\Models\Semester;
use App\Models\StrandSubject;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckListController extends Controller
{
    //

    public function index()
    {

        $studentId = Auth::guard('student')->user()->id;

        $student = Student::find($studentId);

        $semesters = Semester::select('semesters.id as id', 'semesters.semester as semester')
            ->get();

        $gradeLevels = GradeLevel::select('id', 'level')
            ->get();

        $strandSubjects = StrandSubject::join('subjects', 'subjects.id', '=', 'strand_subjects.subject_id')
            ->join('semesters', 'semesters.id', '=', 'strand_subjects.semester_id')
            ->join('grade_levels', 'grade_levels.id', '=', 'strand_subjects.grade_level_id')
            ->select('subjects.subjects as subject', 'subjects.id as subject_id', 'semesters.semester as semester',
                'semesters.id as semester_id', 'grade_levels.level as level', 'grade_levels.id as grade_level_id', 'strand_subjects.id as id')
            ->where('strand_subjects.strand_id', $student->strand_id)
            ->get();

        foreach ($strandSubjects as $subject) {
            $hasGrades = DB::table('final_grades')
                ->where('student_id', $studentId)
                ->where('subject_id', $subject->subject_id)
                ->where('status', 2)
                ->where('quarter', 2)
                ->exists();

            $subject->has_grades = $hasGrades;

            if ($hasGrades) {
                $finalGrade = DB::table('final_grades')
                    ->where('student_id', $studentId)
                    ->where('subject_id', $subject->subject_id)
                    ->value('final_grade');

                $subject->final_grade = $finalGrade;
            }
        }

        return view('students.chechklist', compact('strandSubjects', 'semesters', 'gradeLevels'));
    
}

public function checklist($studentId){

    $email = Auth::user()->email;


     

        $student = Student::find($studentId);


         if(!$student)    {

        abort(404, 'Not found');


        }        


        $semesters = Semester::select('semesters.id as id', 'semesters.semester as semester')
            ->get();

        $gradeLevels = GradeLevel::select('id', 'level')
            ->get();

        $strandSubjects = StrandSubject::join('subjects', 'subjects.id', '=', 'strand_subjects.subject_id')
            ->join('semesters', 'semesters.id', '=', 'strand_subjects.semester_id')
            ->join('grade_levels', 'grade_levels.id', '=', 'strand_subjects.grade_level_id')
            ->select('subjects.subjects as subject', 'subjects.id as subject_id', 'semesters.semester as semester',
                'semesters.id as semester_id', 'grade_levels.level as level', 'grade_levels.id as grade_level_id', 'strand_subjects.id as id')
            ->where('strand_subjects.strand_id', $student->strand_id)
            ->get();

        foreach ($strandSubjects as $subject) {
            $hasGrades = DB::table('final_grades')
                ->where('student_id', $studentId)
                ->where('subject_id', $subject->subject_id)
                ->where('status', 2)
                ->where('quarter', 4)
                ->exists();

            $subject->has_grades = $hasGrades;

            if ($hasGrades) {
                $finalGrade = DB::table('final_grades')
                    ->where('student_id', $studentId)
                    ->where('subject_id', $subject->subject_id)
                    ->value('final_grade');

                $subject->final_grade = $finalGrade;
            }
        }

        return view('admin.checklist', compact('strandSubjects', 'semesters', 'gradeLevels', 'email'));

    }

}

