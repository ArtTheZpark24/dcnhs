<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\FinalGrade;
use App\Models\StrandSubject;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentAuthController extends Controller
{
    //
    public function index(){

        $studentId = Auth::guard('student')->user()->id;

        $student = Student::find($studentId);

        return view('students.dashboard', compact('student'));
    }

    public function subject() {
        $studentId = Auth::guard('student')->user()->id;
        $studentAuth = Student::find($studentId);
    
        $subjects = StrandSubject::join('subjects', 'subjects.id', 'strand_subjects.subject_id')
                                   ->join('semesters', 'semesters.id', 'strand_subjects.semester_id')
                                    ->select('subjects.subjects as subject')
                                    ->where('strand_subjects.strand_id', $studentAuth->strand_id)
                                    ->where('semesters.status', 'active')
                                    ->where('strand_subjects.grade_level_id', $studentAuth->grade_level_id)
                                    ->get();
    
        return view('students.subjects', compact('subjects'));
    }

    public function grades(){

        $studentId = Auth::guard('student')->user()->id;

        $finalGrades = FinalGrade::join('students', 'students.id', '=', 'final_grades.student_id')
        ->join('teachers', 'teachers.id', '=', 'final_grades.teacher_id')
        ->join('subjects', 'subjects.id', '=', 'final_grades.subject_id')
        ->join('semesters', 'semesters.id', '=', 'final_grades.semester_id')
        ->join('school_years', 'school_years.id', '=', 'final_grades.school_year_id')
        ->join('grade_levels', 'grade_levels.id', '=', 'final_grades.grade_level_id')
        ->select('final_grades.final_grade as final_grade', 'subjects.subjects as subject', 'semesters.semester',
            DB::raw('YEAR(school_years.date_start) as year_start'), DB::raw('YEAR(school_years.date_end) as year_end')
            ,'final_grades.quarter as quarter', 'teachers.firstname as firstname', 'teachers.lastname as lastname', 
            DB::raw('SUBSTRING(teachers.middlename, 1, 1) as middle_initial'), 'grade_levels.level as level')
        ->where('students.id', $studentId)
        ->where('final_grades.status', 2)
        ->get();
    

                                   
                                  

        return view('students.grades', compact('finalGrades'));



    }

    public function logout(){

        Auth::guard('student')->logout();
        return redirect('/login/page');


    }
    
    public function class(){

        $studentId = Auth::guard('student')->user()->id;

        $student = Student::find($studentId);


        $classes = Classes::join('student_sections', 'student_sections.section_id', '=', 'classes.section_id')
                            ->join('strand_subjects', 'strand_subjects.id', '=', 'classes.strand_subject_id')
                            ->join('subjects', 'subjects.id', '=', 'strand_subjects.subject_id')
                            ->join('teachers', 'teachers.id', '=', 'classes.teacher_id')
                            ->join('semesters', 'semesters.id', '=', 'classes.semester_id')
                            ->select('classes.time_start as time_start',
                                     'classes.time_end as time_end',
                                     'teachers.firstname as firstname',
                                     'teachers.lastname as lastname', 
                                     DB::raw('SUBSTRING(teachers.middlename, 1, 1) as initial'),
                                     'classes.day as day',
                                     'subjects.subjects as subject')
                            ->where('student_sections.student_id',  $studentId)
                            ->where('semesters.status', 'active')
                            ->get();


        return view('students.class', compact('classes'));



        
    }

    public function profile(){
    

    $studentId = Auth::guard('student')->user()->id;

    $student = Student::find($studentId);

    return view('students.profile', compact('student'));


    }

    public function changeProfile(Request $request){

        $id= Auth::guard('student')->user()->id;

        $student = Student::find($id);

        $validatedData = $request->validate([
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'middlename' => 'required|string|max:255',
            'place_birth' => 'required|string|max:255',
            'date_birth' => 'required|date',
            'email' => 'required|email|max:255|unique:teachers,email,' . $id,
            'street' => 'nullable|string|max:255',
            'brgy' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
             'state' => 'nullable|string|max:255',
            'sex' => 'required|in:Male,Female', 
            
        ], [
            'lastname.required' => 'The lastname field is required.',
            'lastname.max' => 'The lastname may not be greater than 255 characters.',
            'firstname.required' => 'The firstname field is required.',
            'firstname.max' => 'The firstname may not be greater than 255 characters.',
            'middlename.required' => 'The middlename field is required.',
            'middlename.max' => 'The middlename may not be greater than 255 characters.',
            'place_birth.required' => 'The birth place field is required.',
            'place_birth.max' => 'The birth place may not be greater than 255 characters.',
            'date_birth.required' => 'The date of birth field is required.',
            'date_birth.date' => 'The date of birth must be a valid date.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email may not be greater than 255 characters.',
            'email.unique' => 'The email has already been taken.',
            'street.max' => 'The street may not be greater than 255 characters.',
            'brgy.max' => 'The barangay may not be greater than 255 characters.',
            'city.max' => 'The city may not be greater than 255 characters.',
             'state.max' => 'The state may not be greater than 255 characters.',
            'sex.required' => 'The sex field is required.',
            'sex.in' => 'The sex field must be Male or Female.', 
            
        ]);

        $student->update($validatedData);

        return redirect()->back()->with('success', 'Your profile change successfully');

    }

    public function changePassword(){

    return view('students.changepassword');

    }

    public function updatePassword(Request $request){

    $id = Auth::guard('student')->user()->id;

    $student = Student::find($id);

        $validatedData = $request->validate([
    'old-password' => 'required',
    'new-password' => 'required|min:8|different:old-password',
    'password_confirmation' => 'required|same:new-password',
], [
    'old-password.required' => 'Please enter your old password.',
    'new-password.required' => 'Please enter a new password.',
    'new-password.min' => 'The new password must be at least :min characters long.',
    'new-password.different' => 'The new password must be different from the old password.',
    'password_confirmation.required' => 'Please confirm your new password.',
    'password_confirmation.same' => 'Password does not match.',
]);

    if(!Hash::check($validatedData['old-password'], $student->password)){
 
      return redirect()->back()->withErrors('The old password is incorrect');

}

$student->password = Hash::make($validatedData['new-password']);

$student->save();

return redirect()->back()->with('success', 'Password succesfully changed');



    }
}
