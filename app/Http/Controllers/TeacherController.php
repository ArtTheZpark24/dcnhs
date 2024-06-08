<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    //

    public function index(){

        $email = Auth::user()->email;

        return view('admin.teacher', compact('email'));
    }

    public function create(Request $request){

        $validatedData = $request->validate([
            'teacher_id' => 'numeric|required|digits:7|unique:teachers,teacher_id',
            'password' => 'string',
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'middlename' => 'required|string|max:255',
            'rank' => 'required|in:Teacher I,Teacher II,Teacher III,Master Teacher I,Master Teacher II,Master Teacher III,Master Teacher IV',
            'sex' => 'nullable|in:Male,Female', 
            'birth_place' => 'nullable|string|max:255',
            'date_birth' => 'nullable|date',
            'email' => 'required|email|max:255|unique:users,email',
            'phone_number' => 'nullable|numeric|string|digits:11',
            'street' => 'nullable|string|max:255',
            'brgy' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            
            
                ],
              [
                'teacher_id.digits' => 'The teacher ID must be 7 characters.',

             'teacher_id.unique' => 'The teacher ID has already been taken.',
            'teacher_id.numeric' => 'The teacher ID must be a number.',
            'teacher_id.required' => 'The teacher ID field is required.',
            'teacher_id.max' => 'The teacher ID must be 7 characters.',
            'teacher_id.min' => 'The teacher ID must be 7 characters.',
            'lastname.required' => 'The lastname field is required.',
            'lastname.max' => 'The lastname may not be greater than 255 characters.',
            'firstname.required' => 'The firstname field is required.',
            'firstname.max' => 'The firstname may not be greater than 255 characters.',
            'middlename.required' => 'The middlename field is required.',
            'middlename.max' => 'The middlename may not be greater than 255 characters.',
            'rank.required' => 'Please select a rank.',
            'rank.in' => 'The selected rank is invalid.',
            'sex.required' => 'The sex field is required.',
            'sex.in' => 'The selected sex is invalid.',
            'birth_place.required' => 'The birth place field is required.',
            'birth_place.max' => 'The birth place may not be greater than 255 characters.',
            'date_birth.required' => 'The date of birth field is required.',
            'date_birth.date' => 'The date of birth must be a valid date.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email may not be greater than 255 characters.',
            'email.unique' => 'The email has already been taken.',
            'phone_number.numeric' => 'The phone number must be a number.',
            'phone_number.digits' => 'The phone number may not be greater than 15 characters.',
            'street.max' => 'The street may not be greater than 255 characters.',
            'brgy.max' => 'The barangay may not be greater than 255 characters.',
            'city.max' => 'The city may not be greater than 255 characters.',
             'state.max' => 'The state may not be greater than 255 characters.',
            
        ]  );


        $validatedData['password'] = bcrypt($validatedData['teacher_id']);


        Teacher::create($validatedData);

        return redirect()->back()->with('success', 'Teacher successfully created');




    }

    public function data(Request $request){

        $email = Auth::user()->email;

        $datasQuery = Teacher::select('id', 'teacher_id', 'lastname', 'firstname', 'middlename', 'email', 'sex', 'rank',
            'birth_place', 'date_birth', 'street', 'brgy', 'city', 'phone_number', 'state')
            ->whereNull('deleted_at');


            $query = $request->input('query');

  session()->flash('old_query', $query);


  if($query){
   

  $datasQuery = Teacher::where(function($queryBuilder) use ($query){
        $queryBuilder->where('lastname', 'LIKE', "%{$query}")
                     ->orWhere('middlename', 'LIKE', "%{$query}") 
                     ->orWhere('firstname', 'LIKE', "%{$query}")
                     ->orWhere('email', 'LIKE', "%{$query}%")
                     ->orWhere('teacher_id', 'LIKE', "%{$query}%")
                     ->orWhere('phone_number', 'LIKE', "%{$query}%")
                       ->orWhere('state', 'LIKE', "%{$query}%")
                         ->orWhere('brgy', 'LIKE', "%{$query}%")
                           ->orWhere('city', 'LIKE', "%{$query}%")
                             ->orWhere('rank', 'LIKE', "%{$query}%")
                               ->orWhere('sex', 'LIKE', "%{$query}%")
                     ->orWhereRaw("CONCAT(firstname, ' ', lastname, ' ', middlename) LIKE ?", ["%{$query}%"])
                     ->orWhereRaw("CONCAT(lastname, ' ', firstname, ' ', middlename) LIKE ?", ["%{$query}%"])
                     ->orWhereRaw("CONCAT(middlename, ' ', firstname, ' ', lastname) LIKE ?", ["%{$query}%"])
                     ->orWhereRaw("CONCAT(firstname, ' ', middlename, ' ', lastname) LIKE ?", ["%{$query}%"])
                     ->orWhereRaw("CONCAT(lastname, ' ', middlename, ' ', firstname) LIKE ?", ["%{$query}%"])
                     ->orWhereRaw("CONCAT(middlename, ' ', lastname, ' ', firstname) LIKE ?", ["%{$query}%"]);
});
            
     
}    
            $datas = $datasQuery->paginate(10);

        return view('data.teachers', compact('email', 'datas'));
    }

    public function update(Request $request, $id){

        $data = Teacher::find($id);

        if(!$data){

        return view('error.error');

        }


        $validatedData = $request->validate([
            'teacher_id' => 'numeric|required|digits:7|unique:teachers,teacher_id,' . $id,
            'password' => 'string',
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'middlename' => 'required|string|max:255',
            'rank' => 'required|in:Teacher I,Teacher II,Teacher III,Master Teacher I,Master Teacher II,Master Teacher III,Master Teacher IV',
            'sex' => 'nullable|in:Male,Female', 
            'birth_place' => 'nullable|string|max:255',
            'date_birth' => 'nullable|date',
            'email' => 'required|email|max:255|unique:teachers,email,' . $id,
            'phone_number' => 'nullable|string|digits:11|regex:/^09\d{9}$/',
            'street' => 'nullable|string|max:255',
            'brgy' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            
            
                ],
              [
                'teacher_id.digits' => 'The teacher ID must be 7 characters.',

             'teacher_id.unique' => 'The teacher ID has already been taken.',
            'teacher_id.numeric' => 'The teacher ID must be a number.',
            'teacher_id.required' => 'The teacher ID field is required.',
            'teacher_id.max' => 'The teacher ID must be 7 characters.',
            'teacher_id.min' => 'The teacher ID must be 7 characters.',
            'lastname.required' => 'The lastname field is required.',
            'lastname.max' => 'The lastname may not be greater than 255 characters.',
            'firstname.required' => 'The firstname field is required.',
            'firstname.max' => 'The firstname may not be greater than 255 characters.',
            'middlename.required' => 'The middlename field is required.',
            'middlename.max' => 'The middlename may not be greater than 255 characters.',
            'rank.required' => 'Please select a rank.',
            'rank.in' => 'The selected rank is invalid.',
            'sex.required' => 'The sex field is required.',
            'sex.in' => 'The selected sex is invalid.',
            'birth_place.required' => 'The birth place field is required.',
            'birth_place.max' => 'The birth place may not be greater than 255 characters.',
            'date_birth.required' => 'The date of birth field is required.',
            'date_birth.date' => 'The date of birth must be a valid date.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email may not be greater than 255 characters.',
            'email.unique' => 'The email has already been taken.',
            'phone_number.numeric' => 'The phone number must be a number.',
            'phone_number.digits' => 'The phone number may not be greater than 15 characters.',
            'street.max' => 'The street may not be greater than 255 characters.',
            'brgy.max' => 'The barangay may not be greater than 255 characters.',
            'city.max' => 'The city may not be greater than 255 characters.',
             'state.max' => 'The state may not be greater than 255 characters.',
            
        ]  );



        



        $data->update($validatedData);


        return redirect()->route('teachers.data')->with('success', 'Teacher successfully updated');




    }

    public function delete($id){

        $data = Teacher::find($id);

        if(!$data){

        return view('error.error');

        }

        $data->delete();
        return redirect()->back()->with('success', 'Teacher successfully deleted');
    }

   public function archive(Request $request)
{
    $email = Auth::user()->email;


    $datasQuery = Teacher::onlyTrashed('id', 'teacher_id', 'lastname', 'firstname', 'middlename', 'email', 'sex', 'rank',
        'birth_place', 'date_birth', 'street', 'brgy', 'city', 'phone_number', 'state');

    $query = $request->input('query');


    session()->flash('old_query', $query);


    if ($query) {
     
        $datasQuery->where(function($queryBuilder) use ($query) {
            $queryBuilder->where('lastname', 'LIKE', "%{$query}")
                ->orWhere('middlename', 'LIKE', "%{$query}") 
                ->orWhere('firstname', 'LIKE', "%{$query}")
                ->orWhere('email', 'LIKE', "%{$query}%")
                ->orWhere('teacher_id', 'LIKE', "%{$query}%")
                ->orWhere('phone_number', 'LIKE', "%{$query}%")
                ->orWhere('state', 'LIKE', "%{$query}%")
                ->orWhere('brgy', 'LIKE', "%{$query}%")
                ->orWhere('city', 'LIKE', "%{$query}%")
                ->orWhere('rank', 'LIKE', "%{$query}%")
                ->orWhere('sex', 'LIKE', "%{$query}%")
                ->orWhereRaw("CONCAT(firstname, ' ', lastname, ' ', middlename) LIKE ?", ["%{$query}%"])
                ->orWhereRaw("CONCAT(lastname, ' ', firstname, ' ', middlename) LIKE ?", ["%{$query}%"])
                ->orWhereRaw("CONCAT(middlename, ' ', firstname, ' ', lastname) LIKE ?", ["%{$query}%"])
                ->orWhereRaw("CONCAT(firstname, ' ', middlename, ' ', lastname) LIKE ?", ["%{$query}%"])
                ->orWhereRaw("CONCAT(lastname, ' ', middlename, ' ', firstname) LIKE ?", ["%{$query}%"])
                ->orWhereRaw("CONCAT(middlename, ' ', lastname, ' ', firstname) LIKE ?", ["%{$query}%"]);
        });
    }

  
    $datas = $datasQuery->paginate(10);

   
    return view('deleted.teachers', compact('email', 'datas'));
}



    

    public function restore($id){

    $teacher = Teacher::withTrashed()->find($id);


    $teacher->restore();

    return redirect()->back()->with('success', 'Teacher successfully restore');



    }

    public function resetPass($id){

        $teacher = Teacher::find($id);

        if(!$teacher){

            return view('error.error');
        }

        $teacher->password = bcrypt($teacher->teacher_id);
        $teacher->update();

        return redirect()->back()->with('success', 'Password succesfully reset');
    }
}
