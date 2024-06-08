<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Section;
use App\Models\StudentSection;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherLoginController extends Controller
{
    public function index()
    { 
        if(Auth::guard('teacher')->check()){
            return redirect('/teacher/dashboard');
        }
        
        return response()
            ->view('teacher.login')
            ->header('Cache-control', 'no-store, no-cache, must-revalidate, max-age=0');
    }

    public function login(Request $request)
{
   
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


    if (Auth::guard('teacher')->attempt($credentials, $remember)) {
        $request->session()->regenerate();

        if($remember){
            $email = $request->input('email');
            $password = $request->input('password');
            setcookie('email', $email, time()+3600);
            setcookie('password', $password, time()+ 3600);



            }
        return redirect('/teacher/dashboard')->with('success', 'Welcome user');
    }


    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->withInput($request->only('email'));
}
public function dashboard(){



    $teacherId = Auth::guard('teacher')->user()->id;

  $classes = Classes::where('teacher_id', $teacherId)
                      ->join('semesters', 'semesters.id', '=', 'classes.semester_id')
                      ->where('semesters.status', 'active')
                     ->count();
$advisory = StudentSection::join('sections', 'sections.id', '=', 'student_sections.section_id')
                           ->where('sections.teacher_id', $teacherId)
                           ->count('student_sections.student_id');

$subjects = Classes::join('strand_subjects', 'strand_subjects.id', '=', 'classes.strand_subject_id')
                    ->join('subjects', 'subjects.id', '=', 'strand_subjects.subject_id')
                    ->select('subjects.subjects as subject', 'classes.time_start as time_start', 'classes.time_end as time_end')
                    ->where('teacher_id', $teacherId)
->get();
 

    return view('teacher.dashboard', compact('classes', 'advisory', 'subjects'));
}

  public function logout(){

    Auth::guard('teacher')->logout();
    
     return redirect('/teacher/login');
  }
}
