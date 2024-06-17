<?php

namespace App\Http\Controllers;

use App\Imports\StudentsImport;
use App\Models\GradeLevel;
use App\Models\Graduate;
use App\Models\Guardian;
use App\Models\SchoolYear;
use App\Models\Section;
use App\Models\Semester;
use App\Models\Strand;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    //

    public function index(){

        $email = Auth::user()->email;
      
        $guardians = Guardian::select('id', 'firstname', 'lastname')
        ->get();

        $gradeLevel = GradeLevel::select('id', 'level')
        ->get();

        $semesters = Semester::select('semester', 'id')
        ->get();
      
 
         $strands = Strand::select('id','strands')
         ->get();

         
         ;
          $years = SchoolYear::select('id', DB::raw('YEAR(date_start) as start_year'), DB::raw('YEAR(date_end) as end_year'), 'school_year_name', 'status')
            ->get();
           return view('admin.addstudent', compact('email',  'strands',
            'guardians', 'years', 'gradeLevel', 'semesters'));

        
    }

    public function create(Request $request){



        $validatedData = $request->validate([
            'lrn' => 'required|numeric|digits:12|unique:students,lrn',
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'middlename' => 'required|string|max:255',
            'sex' => 'nullable|in:Male,Female',
            'strand_id' => 'required|exists:strands,id',
            'grade_level_id' => 'required|exists:grade_levels,id',
            'school_year_id' => 'nullable|exists:school_years,id',
            'semester_id' => 'required|exists:semesters,id', 
            'place_birth' => 'nullable|string|max:255',
            'date_birth' => 'nullable|date',
            'email' => 'required|email|unique:students,email',
            'street' => 'nullable|string|max:255',
            'brgy' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
        ], [
            'lrn.required' => 'The LRN is required.',
            'lrn.numeric' => 'The LRN must be a number.',
            'lrn.digits' => 'The LRN must be exactly 12 digits.',
            'lrn.unique' => 'The LRN has already been taken.',
            'lastname.required' => 'The last name is required.',
            'lastname.string' => 'The last name must be a string.',
            'lastname.max' => 'The last name may not be greater than 255 characters.',
            'firstname.required' => 'The first name is required.',
            'firstname.string' => 'The first name must be a string.',
            'firstname.max' => 'The first name may not be greater than 255 characters.',
            'middlename.required' => 'The middle name is required.',
            'middlename.string' => 'The middle name must be a string.',
            'middlename.max' => 'The middle name may not be greater than 255 characters.',
            'sex.in' => 'The sex must be either Male or Female.',
            'strand_id.required' => 'The strand ID is required.',
            'strand_id.exists' => 'The selected strand ID is invalid.',
            'grade_level_id.required' => 'The grade level ID is required.',
            'grade_level_id.exists' => 'The selected grade level ID is invalid.',
            'school_year_id.exists' => 'The selected school year ID is invalid.',
            'semester_id.required' => 'The semester ID is required.', 
            'semester_id.exists' => 'The selected semester ID is invalid.', 
            'place_birth.string' => 'The place of birth must be a string.',
            'place_birth.max' => 'The place of birth may not be greater than 255 characters.',
            'date_birth.date' => 'The date of birth is not a valid date.',
            'email.required' => 'The email address is required.',
            'email.email' => 'The email address must be a valid email address.',
            'email.unique' => 'The email address has already been taken.',
            'street.string' => 'The street must be a string.',
            'street.max' => 'The street may not be greater than 255 characters.',
            'brgy.string' => 'The barangay must be a string.',
            'brgy.max' => 'The barangay may not be greater than 255 characters.',
            'city.string' => 'The city must be a string.',
            'city.max' => 'The city may not be greater than 255 characters.',
            'state.string' => 'The state must be a string.',
            'state.max' => 'The state may not be greater than 255 characters.',
        ]);
   
     
     

     $validatedData['password'] = bcrypt($validatedData['lrn']); 
 

    

     Student::create($validatedData);


     return redirect()->route('students.data')->with('success', 'Student Create Successfully');





    }

public function data(Request $request) {
    $email = Auth::user()->email;

    $datasQuery = Student::leftJoin('strands', 'strands.id', '=', 'students.strand_id')
        ->leftJoin('grade_levels', 'grade_levels.id', '=', 'students.grade_level_id')
        ->leftJoin('semesters', 'semesters.id', '=', 'students.semester_id')
        ->select(
            'students.id as id',
            'students.lrn as lrn',
            'students.lastname as lastname',
            'students.firstname as firstname',
            'students.middlename as middlename',
            'students.sex as sex',
            'strands.strands as strand',
            'strands.id as strand_id',
            'grade_levels.level as level',
            'grade_levels.id as level_id',
            'students.place_birth as place_birth',
            'students.date_birth as date_birth',
            'students.email as email',
            'students.street as street',
            'students.brgy as brgy',
            'students.city as city',
            'students.state as state',
            'semesters.id as semester_id'
        )
        ->whereNull('students.deleted_at')
        ->orderBy('lastname');

    $query = $request->input('query');

    session()->flash('old_query', $query);

if ($query) {
    $datasQuery->join('strands as strand_join', 'strand_join.id', '=', 'students.strand_id')
               ->join('grade_levels as levels', 'levels.id', '=', 'students.grade_level_id')
        ->where(function($queryBuilder) use ($query) {
            $queryBuilder->where('students.lastname', 'LIKE', "%{$query}")
                         ->orWhere('students.middlename', 'LIKE', "%{$query}") 
                         ->orWhere('students.firstname', 'LIKE', "%{$query}")
                         ->orWhere('students.email', 'LIKE', "%{$query}%")
                         ->orWhere('students.lrn', 'LIKE', "%{$query}%")
                         ->orWhere('levels.level', 'LIKE', "%{$query}%")
                         ->orWhere('strand_join.strands', 'LIKE', "%{$query}%") 
                         ->orWhere('students.sex', 'LIKE', "%{$query}%")
                         ->orWhere('students.place_birth', 'LIKE', "%{$query}%")
                         ->orWhere('students.date_birth', 'LIKE', "%{$query}%")
                         ->orWhere('students.street', 'LIKE', "%{$query}%")
                         ->orWhere('students.brgy', 'LIKE', "%{$query}%")
                         ->orWhere('students.city', 'LIKE', "%{$query}%")
                         ->orWhere('students.state', 'LIKE', "%{$query}%")
                        ->orWhereRaw("CONCAT(strand_join.strands, '-', levels.level) LIKE ?", ["%{$query}%"])
                         ->orWhereRaw("CONCAT(students.firstname, ' ', students.lastname, ' ', students.middlename) LIKE ?", ["%{$query}%"])
                         ->orWhereRaw("CONCAT(students.lastname, ' ', students.firstname, ' ', students.middlename) LIKE ?", ["%{$query}%"])
                         ->orWhereRaw("CONCAT(students.middlename, ' ', students.firstname, ' ', students.lastname) LIKE ?", ["%{$query}%"])
                         ->orWhereRaw("CONCAT(students.firstname, ' ', students.middlename, ' ', students.lastname) LIKE ?", ["%{$query}%"])
                         ->orWhereRaw("CONCAT(students.lastname, ' ', students.middlename, ' ', students.firstname) LIKE ?", ["%{$query}%"])
                         ->orWhereRaw("CONCAT(strand_join.strands, ' ',levels.level) LIKE ?", ["%{$query}%"])
                         ->orWhereRaw("CONCAT(students.middlename, ' ', students.lastname, ' ', students.firstname) LIKE ?", ["%{$query}%"]);
        });
}



    $datas = $datasQuery->paginate(10);

    $guardians = Guardian::select('id', 'firstname', 'lastname')->get();
    $gradeLevel = GradeLevel::select('id', 'level')->get();
    $strands = Strand::select('id','strands')->get();
    $semesters = Semester::select('semester', 'id', 'status')->get();
    $years = SchoolYear::select('id', DB::raw('YEAR(date_start) as start_year'), DB::raw('YEAR(date_end) as end_year'), 'school_year_name')->get();

    return view('data.students', compact('email', 'datas', 'guardians', 'gradeLevel', 'strands', 'semesters', 'years'));
}



    public function update(Request $request ,$id){

        $data = Student::find($id);

        $validatedData = $request->validate([
            'lrn' => 'nullable|numeric|digits:12|unique:students,lrn,' . $id,
            'lastname' => 'nullable|string|max:255',
            'firstname' => 'nullable|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'sex' => 'nullable|in:Male,Female',
            'strand_id' => 'nullable|exists:strands,id',
            'grade_level_id' => 'nullable|exists:grade_levels,id',
            'school_year_id' => 'nullable|exists:school_years,id',
            'place_birth' => 'nullable|string|max:255',
            'date_birth' => 'nullable|date',
            'email' => 'nullable|email|unique:students,email,' . $id,
            
            'street' => 'nullable|string|max:255',
            'brgy' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
        ], [
            'lrn.numeric' => 'LRN must be numeric.',
            'lrn.digits' => 'LRN must be 12 digits.',
            'lrn.unique' => 'LRN already exists.',
            'lastname.max' => 'Last name may not be greater than :max characters.',
            'firstname.max' => 'First name may not be greater than :max characters.',
            'middlename.max' => 'Middle name may not be greater than :max characters.',
            'sex.in' => 'Sex must be either Male or Female.',
            'strand_id.exists' => 'Selected strand does not exist.',
            'grade_level_id.exists' => 'Selected grade level does not exist.',
            'school_year_id.exists' => 'Selected school year does not exist.',
            'place_birth.max' => 'Place of birth may not be greater than :max characters.',
            'date_birth.date' => 'Date of birth must be a valid date.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'Email already exists.',
            'street.max' => 'Street may not be greater than :max characters.',
            'brgy.max' => 'Barangay may not be greater than :max characters.',
            'city.max' => 'City may not be greater than :max characters.',
            'state.max' => 'State may not be greater than :max characters.',
        ]);
        



   $data->update($validatedData);

return redirect()->back()->with('success', 'Student successfully updated');

 


    }

    public function delete($id){

    $data = Student::find($id);

    if(!$data){
      

      return view('error.error');

    }

    $data->delete();


    return redirect()->back()->with('success', 'Student successfully delete');




    }


    public function archive(Request $request){

     $email = Auth::user()->email;

  

    $datasQuery = Student::onlyTrashed()
    ->leftJoin('strands', 'strands.id', '=', 'students.strand_id')
        ->leftJoin('grade_levels', 'grade_levels.id', '=', 'students.grade_level_id')
        ->leftJoin('semesters', 'semesters.id', '=', 'students.semester_id')
        ->select(
            'students.id as id',
            'students.lrn as lrn',
            'students.lastname as lastname',
            'students.firstname as firstname',
            'students.middlename as middlename',
            'students.sex as sex',
            'strands.strands as strand',
            'strands.id as strand_id',
            'grade_levels.level as level',
            'grade_levels.id as level_id',
            'students.place_birth as place_birth',
            'students.date_birth as date_birth',
            'students.email as email',
            'students.street as street',
            'students.brgy as brgy',
            'students.city as city',
            'students.state as state',
            'semesters.id as semester_id'
        )
        ->orderBy('lastname');

    $query = $request->input('query');

    session()->flash('old_query', $query);

if ($query) {
    $datasQuery->join('strands as strand_join', 'strand_join.id', '=', 'students.strand_id')
               ->join('grade_levels as levels', 'levels.id', '=', 'students.grade_level_id')
        ->where(function($queryBuilder) use ($query) {
            $queryBuilder->where('students.lastname', 'LIKE', "%{$query}")
                         ->orWhere('students.middlename', 'LIKE', "%{$query}") 
                         ->orWhere('students.firstname', 'LIKE', "%{$query}")
                         ->orWhere('students.email', 'LIKE', "%{$query}%")
                         ->orWhere('students.lrn', 'LIKE', "%{$query}%")
                         ->orWhere('levels.level', 'LIKE', "%{$query}%")
                         ->orWhere('strand_join.strands', 'LIKE', "%{$query}%") // Use the alias for the joined table
                         ->orWhere('students.sex', 'LIKE', "%{$query}%")
                         ->orWhere('students.place_birth', 'LIKE', "%{$query}%")
                         ->orWhere('students.date_birth', 'LIKE', "%{$query}%")
                         ->orWhere('students.street', 'LIKE', "%{$query}%")
                         ->orWhere('students.brgy', 'LIKE', "%{$query}%")
                         ->orWhere('students.city', 'LIKE', "%{$query}%")
                         ->orWhere('students.state', 'LIKE', "%{$query}%")
                         ->orWhereRaw("CONCAT(students.firstname, ' ', students.lastname, ' ', students.middlename) LIKE ?", ["%{$query}%"])
                         ->orWhereRaw("CONCAT(students.lastname, ' ', students.firstname, ' ', students.middlename) LIKE ?", ["%{$query}%"])
                         ->orWhereRaw("CONCAT(students.middlename, ' ', students.firstname, ' ', students.lastname) LIKE ?", ["%{$query}%"])
                         ->orWhereRaw("CONCAT(students.firstname, ' ', students.middlename, ' ', students.lastname) LIKE ?", ["%{$query}%"])
                         ->orWhereRaw("CONCAT(students.lastname, ' ', students.middlename, ' ', students.firstname) LIKE ?", ["%{$query}%"])
                         ->orWhereRaw("CONCAT(strand_join.strands, ' ',levels.level) LIKE ?", ["%{$query}%"])
                         
                         ->orWhereRaw("CONCAT(students.middlename, ' ', students.lastname, ' ', students.firstname) LIKE ?", ["%{$query}%"]);
        });
}
  $datas = $datasQuery->paginate(10);
    

      return view('deleted.students', compact('email', 'datas'));



    } 

    public function resetPass($id){

     $student = Student::find($id);

     if(!$student){


     return view('error.error');

     }

     $student->password = bcrypt($student->lrn);

     $student->update();

     return redirect()->back()->with('success', 'Student' . ' '. $student->lrn. ' '. 'succesfully reset the password');

    }

    public function restore($id){

    $student = Student::withTrashed()->find($id);

    if(!$student){

    return view('error.error');

    }

    $student->restore();

    return redirect()->back()->with('success', 'Student successfully restore');


    }

    public function graduates(){

    $email = Auth::user()->email;
    

$graduates = Graduate::join('students', 'students.id', '=', 'graduates.student_id')
                     ->join('school_years', 'school_years.id', '=', 'graduates.school_year_id')
                     ->select('students.lastname as lastname', 
                              'students.firstname as firstname',
                              'graduates.id as id', 'students.id as student_id', 
                              DB::raw("SUBSTRING(students.middlename, 1, 1) as initial"),
                              DB::raw("YEAR(school_years.date_start) as year_start"),
                              DB::raw("YEAR(school_years.date_end) as year_end"))
                              ->orderBy('lastname')
                     ->get();



    return view('admin.graduates', compact('email', 'graduates'));

    }

    public function gradDel($id, $stud_id){

    $grad = Graduate::find($id);

    $student = Student::find($stud_id);


    if(!$grad || ! $student){



    return view('error.error');


    }

    $grad->delete();

    $student->status = 1;

    $student->save();

    return redirect()->back()->with('success', 'Sucessfully delete');


    }

    
}
