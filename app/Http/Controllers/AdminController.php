<?php

namespace App\Http\Controllers;

use App\Models\FinalGrade;
use App\Models\GradeLevel;
use App\Models\Guardian;
use App\Models\SchoolYear;
use App\Models\Semester;
use App\Models\Strand;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use PhpParser\Node\Stmt\Finally_;

class AdminController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return redirect('/admin/dashboard');
        }

        return response()
            ->view('admin.login')
            ->header('Cache-control', 'no-store, no-cache, must-revalidate, max-age=0');
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password'=> 'required'
        ], [
            'email.required' => 'Please enter an email',
            'email.email' => 'Please enter a valid email',
            'password.required'=> 'Please enter a password'
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember-me');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            

            if($remember){
            $email = $request->input('email');
            $password = $request->input('password');
            setcookie('email', $email, time()+3600);
            setcookie('password', $password, time()+ 3600);



            }

            return redirect('/admin/dashboard')->with('success', 'Welcome user');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email', 'remember-me'));
    }

    public function adminDashboard(Request $request)
    
    {

   $totalStudents = Student::whereNull('deleted_at')->count();
$totalTeachers = Teacher::whereNull('deleted_at')->count();
$totalParents = Guardian::whereNull('deleted_at')->count();
$resignedTeachers = Teacher::onlyTrashed()->count();
    $studentMale = Student::where('sex', 'Male')->count();
    $studentFemale = Student::where('sex', 'Female')->count();
        $email = Auth::user()->email;

      $semesters = Semester::select('id', 'semester')->get();

    


   $query = FinalGrade::join('students', 'students.id', '=', 'final_grades.student_id')
    ->join('semesters', 'semesters.id', '=', 'final_grades.semester_id')
    ->join('strands', 'strands.id', '=', 'students.strand_id')
    ->join('grade_levels', 'grade_levels.id', 'final_grades.grade_level_id')
    ->join('school_years', 'school_years.id', '=', 'final_grades.school_year_id')
    
    ->select(
        'students.id as student_id',
        'students.firstname as firstname',
        'students.lastname as lastname',
        'students.middlename as middlename',
        'strands.strands as strand',
        'final_grades.subject_id',
        'grade_levels.level as level',
        DB::raw('AVG(final_grades.final_grade) as subject_average_grade')
    )
    ->whereIn('final_grades.quarter', [1, 2]) 
    ->groupBy('students.id', 'students.firstname', 'grade_levels.level',
    'students.lastname', 'strands','students.middlename', 'final_grades.subject_id')
    ->havingRaw('COUNT(DISTINCT final_grades.quarter) = 2')
    ->where('final_grades.final_grade', '>=', 85);
   
    

 

    if ($request->has('semester_id')) {
        $semester = $request->input('semester_id');
        $query->where('final_grades.semester_id', $semester);
    } else {
        $query->where('semesters.status', 'active');
    }

    if ($request->has('school_year_id')) {
        $schoolYear = $request->input('school_year_id');
        $query->where('final_grades.school_year_id', $schoolYear);
    } else {
        $query->where('school_years.status', 2);
    }

    if ($request->has('strand_id')) {
        $strand = $request->input('strand_id');
        $query->where('students.strand_id', $strand);
    }

    if ($request->has('level_id')) {
        $level = $request->input('level_id');
        $query->where('final_grades.grade_level_id', $level);
    }


       $subjectAverages = $query->paginate(10);
        $sumAvg = $subjectAverages->sum('subject_average_grade');

 $divisor = $subjectAverages->count();
   $semesters = Semester::select('semester', 'status', 'id')->get();

   $strands = Strand::select('strands', 'description', 'id')->orderBy('strands')->get();
   $levels = GradeLevel::select('level', 'id')->orderBy('level')->get();

       if($divisor == 0){

$result = 0;

}

else{
$result =  $sumAvg / $divisor ;
}

$showResult = false;

if($result >= 90){

$showResult = true;

}

else{
 $showResult = false;
}



       if($request->ajax()){
       

       return view('partials.achievers', compact('subjectAverages', 'showResult', 'result'));

       }




  $schoolYears = SchoolYear::select(  DB::raw('YEAR(date_start) as year_start'),
            DB::raw('YEAR(date_end) as year_end'), 'id', 'status')->get();






    

        
        return view('admin.dashboard', compact('email',
        'semesters',
        'subjectAverages',
         'totalStudents',
          'totalTeachers', 
          'totalParents',
          'resignedTeachers', 
          'studentMale', 
          'studentFemale',
          'semesters',  
          'result',
          'divisor',
          'schoolYears',
          'showResult',
          'strands',
          'levels'
          
        ));
    }

    public function adminLogout()
    {
        auth()->logout();
        return redirect('/login/page');
    }
       public function addAdmin(){

        $email = Auth::user()->email;


        return view('admin.admin', compact('email'));
   
       }


       public function create(Request $request){


        $validatedData = $request->validate([

            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'required|boolean',
        
        
        ],
    
     [
    'name.required' => 'The name field is required.',
    'name.string' => 'The name must be a string.',
    'name.max' => 'The name may not be greater than :max characters.',
    'email.required' => 'The email field is required.',
    'email.email' => 'The email must be a valid email address.',
    'email.unique' => 'The email has already been taken.',
    'password.required' => 'The password field is required.',
    'password.string' => 'The password must be a string.',
    'password.min' => 'The password must be at least :min characters.',
    'password.confirmed' => 'The password confirmation does not match.',
    'is_admin.required' => 'The admin role field is required.',
    'is_admin.boolean' => 'The admin role must be a boolean value.',
]);


  User::create($validatedData);

  return redirect()->route('admin.data')->with('success', 'Admin succesfully created');



       }

  public function data(Request $request){

    $email = Auth::user()->email;

    $query = $request->input('query');

    session()->flash('old_query', $query);

    
    $admins = User::select('id', 'name', 'email', 'is_admin')
                  ->whereNull('deleted_at')
                  ->orderBy('name');


    if($query) {
        $admins->where(function($queryBuilder) use ($query) {
            $queryBuilder->where('name', 'LIKE', "%{$query}")
                         ->orWhere('email', 'LIKE', "%{$query}");
                        
        });
    }


    $admins = $admins->paginate(10);

    
    return view('data.admin', compact('email', 'admins'));
}

       

       public function update(Request $request, $id){

       $admins = User::find($id);

       $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,'.$id,
        'password' => 'nullable|string|min:8|confirmed',
        'is_admin' => 'required|boolean',
    ]);
 
      $admins->update($validatedData);

        return redirect()->back()->with('success', 'Admin succesfully updated');



       }
     
    


     
    public function delete($id){

    $admins = User::find($id);

    $admins->delete();

    return redirect()->back()->with('success', 'Admin succesfully deleted');




    }

 public function archive(Request $request)
{
  
    $email = Auth::user()->email;


    $query = $request->input('query');


    session()->flash('old_query', $query);

    $admins = User::onlyTrashed() 
                  ->orderBy('name');

 
    if ($query) {
        $admins->where(function($queryBuilder) use ($query) {
            $queryBuilder->where('name', 'LIKE', "%{$query}")
                         ->orWhere('email', 'LIKE', "%{$query}");
        });
    }

 
    $admins = $admins->paginate(10);

    return view('deleted.admin', compact('email', 'admins'));
}


    public function changeProfile(){

    $id = Auth::user()->id;

    $admin = User::find($id);

    $email = Auth::user()->email;



    return view('admin.profile', compact('email', 'admin'));




    }
    public function changeProfilePost(Request $request){


        $id = Auth::user()->id;

        $user = User::find($id);

        $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'email',
            'max:255',
            Rule::unique('users')->ignore($id)
        ],
    ] ,[
    
    'name.required' => 'The name field is required.',
        'name.string' => 'The name must be a string.',
        'name.max' => 'The name may not be greater than :max characters.',
        'email.required' => 'The email field is required.',
        'email.email' => 'The email must be a valid email address.',
        'email.max' => 'The email may not be greater than :max characters.',
        'email.unique' => 'The email has already been taken.',
    ]);

    $user->name = $validatedData['name'];
     $user->email = $validatedData['email'];
     $user->update();
      return redirect()->back()->with('success', 'Profile updated successfully');



    }

    public function changePassword(){

   

    $email = Auth::user()->email;

    return view('admin.settings', compact('email'));




    }

    public function updatePassword(Request $request){


     $adminId = Auth::user()->id;

     $user = User::find($adminId);

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
    'password_confirmation.same' => 'The confirmation does not match the new password.',
]);


    if(!Hash::check($validatedData['old-password'], $user->password)){

     return redirect()->back()->withErrors('The old password is incorrect');
    }

    $user->password = Hash::make($validatedData['new-password']);
    $user->update();

    return redirect()->back()->with('success', 'Password successfully changed');

    }
    

   

  
  public function restore($id){

  $user = User::withTrashed($id);

  $user->restore();

   return redirect()->back()->with('success', 'Admin succesfully restored');


  }


 
}
