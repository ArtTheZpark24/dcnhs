<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class GuardianController extends Controller
{
    //
    public function index(){

        $email = Auth::user()->email;

        return view('admin.guardian', compact('email'));
    }

    public function create(Request $request)
{
  $validatedData =   $request->validate([
         'password' => 'string',
        'lastname' => 'required|string|max:255',
        'middlename' => 'required|string|max:255',
        'firstname' => 'required|string|max:255',
         'phone' => 'nullable|string|digits:11|regex:/^09\d{9}$/',
        'place_of_birth' => 'nullable|string|max:255',
        'email' => 'required|string|email|unique:guardians|max:255',
        'birth_date' => 'nullable|date',
        'street' => 'nullable|string|max:255',
        'barangay' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:255',
        'sex' => 'nullable|in:Male,Female',
    ] , [
    'lastname.required' => 'Please provide your last name.',
    'middlename.required' => 'Please provide your middle name.',
    'firstname.required' => 'Please provide your first name.',


    'email.required' => 'Please provide your email address.',
    'email.email' => 'Please provide a valid email address.',
    'email.unique' => 'The email address has already been taken.',
    'sex.in' => 'The selected sex is invalid.',
]);


    $validatedData['password'] = bcrypt('password1234');

    Guardian::create($validatedData);

    return redirect()->back()->with('success', 'Guardian successfully created');

     
}


public function data(Request $request){

    $email = Auth::user()->email;



    $datas = Guardian::select('id', 'lastname', 'firstname', 'middlename', 'phone', 'occupation', 'place_of_birth',
                          'email', 'birth_date', 'street', 'barangay', 'city', 'state', 'sex')
                ->whereNull('deleted_at')
                ->orderBy('lastname');
                
                $query = $request->input('query');

                session()->flash('old_query', $query);
                if ($query) {
        $datas = Guardian::where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('lastname', 'LIKE', "%{$query}%")
                         ->orWhere('firstname', 'LIKE', "%{$query}%")
                         ->orWhere('middlename', 'LIKE', "%{$query}%")
                         ->orWhere('email', 'LIKE', "%{$query}%")
                         ->orWhere('occupation', 'LIKE', "%{$query}%")
                         ->orWhere('phone', 'LIKE', "%{$query}%")
                        ->orWhereRaw("CONCAT(firstname, ' ', lastname, ' ', middlename) LIKE ?", ["%{$query}%"])
                         ->orWhereRaw("CONCAT(lastname, ' ', firstname, ' ', middlename) LIKE ?", ["%{$query}%"])
                         ->orWhereRaw("CONCAT(middlename, ' ', firstname, ' ', lastname) LIKE ?", ["%{$query}%"])
                         ->orWhereRaw("CONCAT(firstname, ' ', middlename, ' ', lastname) LIKE ?", ["%{$query}%"])
                         ->orWhereRaw("CONCAT(lastname, ' ', middlename, ' ', firstname) LIKE ?", ["%{$query}%"])
                         ->orWhereRaw("CONCAT(middlename, ' ', lastname, ' ', firstname) LIKE ?", ["%{$query}%"]);
        });
    }
    $datas = $datas->paginate(10);
    return view('data.guardians', compact('email','datas'));
}

public function update(Request $request, $id) {
    $data = Guardian::findOrFail($id);

    $validatedData =   $request->validate([
        'password' => 'string',
       'lastname' => 'required|string|max:255',
       'middlename' => 'required|string|max:255',
       'firstname' => 'required|string|max:255',
       'phone' => 'nullable|string|digits:11|regex:/^09\d{9}$/',
       'place_of_birth' => 'nullable|string|max:255',
      'email' => 'required|string|email|unique:guardians,email,' . $id . ',id|max:255',
       'birth_date' => 'nullable|date',
       'street' => 'nullable|string|max:255',
       'barangay' => 'nullable|string|max:255',
       'city' => 'nullable|string|max:255',
       'sex' => 'nullable|in:Male,Female',
       'occupation' => 'nullable|string|max:255',
   ] , [
   'lastname.required' => 'Please provide your last name.',
   'middlename.required' => 'Please provide your middle name.',
   'firstname.required' => 'Please provide your first name.',
   'email.required' => 'Please provide your email address.',
   'email.email' => 'Please provide a valid email address.',
   'email.unique' => 'The email address has already been taken.',
   'sex.in' => 'The selected sex is invalid.',
]);



    

    

    $data->update($validatedData);

    return redirect()->route('guardians.data')->with('success', 'Guardian successfully updated');
}

public function delete($id){


$guardian = Guardian::find($id);

$guardian->delete();

return redirect()->route('guardians.data')->with('success', 'Guardian successfully deleted');





}

public function archive(Request $request){

    $email = Auth::user()->email;



    $datas = Guardian::onlyTrashed('id', 'lastname', 'firstname', 'middlename', 'phone', 'occupation', 'place_of_birth',
                          'email', 'birth_date', 'street', 'barangay', 'city', 'state', 'sex')
                
                ->orderBy('lastname');
                
                $query = $request->input('query');

                session()->flash('old_query', $query);
                if ($query) {
        $datas = Guardian::where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('lastname', 'LIKE', "%{$query}%")
                         ->orWhere('firstname', 'LIKE', "%{$query}%")
                         ->orWhere('middlename', 'LIKE', "%{$query}%")
                         ->orWhere('email', 'LIKE', "%{$query}%")
                        ->orWhereRaw("CONCAT(firstname, ' ', lastname, ' ', middlename) LIKE ?", ["%{$query}%"])
                         ->orWhereRaw("CONCAT(lastname, ' ', firstname, ' ', middlename) LIKE ?", ["%{$query}%"])
                         ->orWhereRaw("CONCAT(middlename, ' ', firstname, ' ', lastname) LIKE ?", ["%{$query}%"])
                         ->orWhereRaw("CONCAT(firstname, ' ', middlename, ' ', lastname) LIKE ?", ["%{$query}%"])
                         ->orWhereRaw("CONCAT(lastname, ' ', middlename, ' ', firstname) LIKE ?", ["%{$query}%"])
                         ->orWhereRaw("CONCAT(middlename, ' ', lastname, ' ', firstname) LIKE ?", ["%{$query}%"]);
        });
    }
    $datas = $datas->paginate(10);

    return view('deleted.guardians', compact('email','datas'));



}
public function restoreAll (Request $request){

    $ids = $request->input('ids');

    if(!empty($ids)){

    Guardian::withTrashed()->whereIn('id', $ids)->restore();

     session()->flash('success', 'Selected records have been restore successfully.');

   return redirect()->back();
    } else {
        return redirect()->route('guardians.archive')->withErrors( 'No records selected.');
    }

    

    
}

public function restore($id){
    $guardian = Guardian::onlyTrashed()->find($id);

   
    if (!$guardian) {
        return redirect()->back()->with('error', 'Guardian not found');
    }

  
    $guardian->restore();

    return redirect()->back()->with('success', 'Guardian successfully restored');


}

public function resetPass($id){

    $guardian = Guardian::find($id);

    if(!$guardian){

        return view('error.error');
    }

    $guardian->password = bcrypt('password1234');

return redirect()->back()->with('success', 'Password Succesfully reset');
}

}

