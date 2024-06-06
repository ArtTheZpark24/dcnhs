<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\FinalGrade;
use App\Models\GradeLevel;
use App\Models\Guardian;
use App\Models\Semester;
use App\Models\StrandSubject;
use App\Models\Student;
use App\Models\StudentGuardian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GuardiansAuthController extends Controller
{
    //

    public function index(){


   
     if(Auth::guard('guardian')->check()) {
            return redirect('home/guardian');
        }
        
        return response()
            ->view('guardian.login')
            ->header('Cache-control', 'no-store, no-cache, must-revalidate, max-age=0');
    }

    public function login(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'The email field is required.',
            'email.email' => 'Please provide a valid email address.',
            'password.required' => 'The password field is required.',
        ]);

        $credentials = $request->only('email', 'password');

        $remember = $request->has('remember-me');

        if(Auth::guard('guardian')->attempt($credentials, $remember)){


            $request->session()->regenerate();

            if($remember){

                $email = $request->input('email');
            $password = $request->input('password');
            setcookie('email', $email, time()+3600);
            setcookie('password', $password, time()+ 3600);

            }

            return redirect('home/guardian')->with('success', 'Welcome user');

        }

        return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->withInput($request->only('email'));

    

    }

    public function logout(){

    Auth::guard('guardian')->logout();

    return redirect('/guardians/login');


    }


    public function home(){

    $guardianId  = Auth::guard('guardian')->user()->id;

    $guardian = Guardian::find($guardianId);


        return view('guardian.home', compact('guardian'));
    }



    public function studentList(){


  $guardianId  = Auth::guard('guardian')->user()->id;
    $guardianStudents = StudentGuardian::join('students', 'students.id', 'student_guardians.student_id')
                                           ->select('students.firstname as firstname', 'students.lastname as lastname',  DB::raw('LEFT(middlename, 1) as middle_initial'), 'students.id as student_id')
                                           ->where('student_guardians.guardian_id', $guardianId)
                                           ->get();


     return view('guardian.students', compact('guardianStudents'));                                      

    }

    public function studentGrades($student_id){
    $guardianId  = Auth::guard('guardian')->user()->id;

    $student = Student::find($student_id);


     $guardianStudents = StudentGuardian::join('students', 'students.id', 'student_guardians.student_id')
                                           ->where('student_guardians.guardian_id', $guardianId)
                                           ->where('student_guardians.student_id', $student_id)
                                           ->first();


        if(!$guardianStudents)    {

        abort(404, 'Not found');


        }                                

    if(!$student){

    abort(404, 'Not found');


    }

  
     $finalGrades = FinalGrade::join('students', 'students.id', '=', 'final_grades.student_id')
                                     ->join('subjects', 'subjects.id', '=', 'final_grades.subject_id')
                                     ->join('semesters', 'semesters.id', 'final_grades.semester_id')
                                     ->join('student_guardians', 'student_guardians.student_id', '=', 'final_grades.student_id')
                                     ->join('teachers', 'teachers.id', 'final_grades.teacher_id')
                                     ->join('grade_levels', 'grade_levels.id', 'final_grades.grade_level_id')
                                     ->select( 'final_grades.final_grade as final_grade',
                                                'final_grades.quarter as quarter',
                                                'subjects.subjects as subject', 'semesters.semester as semester', 
                                                'teachers.firstname', 'teachers.lastname', 'teachers.middlename', 'grade_levels.level as level')
                                     ->where('students.id',$student_id )
                                     ->where('student_guardians.guardian_id', $guardianId)
                                     ->where('final_grades.status', 2)
                                     ->get();

                    
                    return view('guardian.studentgrades', compact('finalGrades', 'student'));



       





    }

    public function studentClass($student_id){


  $guardianId  = Auth::guard('guardian')->user()->id;
    $student = Student::find($student_id);

     $guardianStudents = StudentGuardian::join('students', 'students.id', 'student_guardians.student_id')
                                           ->where('student_guardians.guardian_id', $guardianId)
                                           ->where('student_guardians.student_id', $student_id)
                                           ->first();



    
        if(!$guardianStudents)    {

        abort(404, 'Not found');


        }                                

    if(!$student){

    abort(404, 'Not found');


    }




        $classes = Classes ::join('student_sections', 'student_sections.section_id', '=', 'classes.section_id')
        ->join('strand_subjects', 'strand_subjects.id', '=', 'classes.strand_subject_id')
        ->join('subjects', 'subjects.id', '=', 'strand_subjects.subject_id')
        ->join('teachers', 'teachers.id', '=', 'classes.teacher_id')
        ->join('semesters', 'semesters.id', '=', 'classes.semester_id')
        ->join('student_guardians', 'student_guardians.student_id', '=', 'student_sections.student_id')
        ->select('classes.time_start as time_start',
                 'classes.time_end as time_end',
                 'teachers.firstname as firstname',
                 'teachers.lastname as lastname', 
                 DB::raw('SUBSTRING(teachers.middlename, 1, 1) as initial'),
                 'classes.day as day',
                 'subjects.subjects as subject')
        ->where('student_sections.student_id', $student_id)
        ->where('classes.semester_id', $student->semester_id )
        ->where('semesters.status', 'active')
        ->where('student_guardians.guardian_id', $guardianId)
        ->get();


        return view('guardian.class', compact('classes', 'student'));
    }

    public function checkList($studentId){
          $guardianId  = Auth::guard('guardian')->user()->id;

         $guardianStudents = StudentGuardian::join('students', 'students.id', 'student_guardians.student_id')
                                           ->where('student_guardians.guardian_id', $guardianId)
                                           ->where('student_guardians.student_id', $studentId)
                                           ->first();



    
        if(!$guardianStudents)    {

        abort(404, 'Not found');


        }        

     

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

        return view('guardian.checklist', compact('strandSubjects', 'semesters', 'gradeLevels'));

    }

   public function profile()
{
    $guardianId = Auth::guard('guardian')->user()->id;
    $guardian = Guardian::find($guardianId);
    return view('guardian.profile', compact('guardian'));
}

public function updateProfile(Request $request)
{
    $guardianId = Auth::guard('guardian')->user()->id;
    $guardian = Guardian::find($guardianId);

$validatedData = $request->validate([
    'lastname' => 'required|string|max:255',
    'place_of_birth' => 'required|string|max:255',
    'firstname' => 'required|string|max:255',
    'email' => 'required|email|max:255',
    'middlename' => 'required|string|max:255',
    'phone' => 'required|string|max:15',
    'sex' => 'required|in:Male,Female',
    'birth_date' => 'required|date',
    'occupation' => 'nullable|string|max:255',
    'street' => 'nullable|string|max:255',
    'barangay' => 'nullable|string|max:255',
    'state' => 'nullable|string|max:255',
], [
    'lastname.required' => 'The lastname field is required.',
    'place_of_birth.required' => 'The place of birth field is required.',
    'firstname.required' => 'The firstname field is required.',
    'email.required' => 'The email field is required.',
    'email.email' => 'Please enter a valid email address.',
    'middlename.required' => 'The middlename field is required.',
    'phone.required' => 'The phone number field is required.',
    'phone.max' => 'The phone number may not be greater than 15 characters.',
    'sex.required' => 'Please select a sex.',
    'birth_date.required' => 'The birth date field is required.',
    'birth_date.date' => 'Please enter a valid date for the birth date.',
    'occupation.max' => 'The occupation may not be greater than 255 characters.', 
]);



    $guardian->update($validatedData);

    return redirect()->back()->with('success', 'Profile updated successfully');
}

public function changePassword(){


return view('guardian.changepassword');


}

public function updatePassword(Request $request){

$guardianId = Auth::guard('guardian')->user()->id;

$guardian = Guardian::find($guardianId);

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

 if(!Hash::check($validatedData['old-password'], $guardian->password)){
 
      return redirect()->back()->withErrors('The old password is incorrect');

}

$guardian->password = Hash::make($validatedData['new-password']);

$guardian->save();

return redirect()->back()->with('success', 'Password succesfully changed');

}
    

}
