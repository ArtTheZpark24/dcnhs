<?php

namespace App\Http\Controllers;

use App\Imports\GradesImport;
use App\Mail\GradesSubmitted;
use App\Models\Classes;
use App\Models\FinalGrade; 
use App\Models\User;
use App\Notifications\NewGradesSubmitted;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException; 
use Maatwebsite\Excel\Facades\Excel;

class ImportGradesController extends Controller
{
    public function index()
    {
        $teacherId = Auth::guard('teacher')->user()->id;

        $subjectClass = Classes::join('strand_subjects', 'strand_subjects.id', 'classes.strand_subject_id')
            ->join('subjects', 'subjects.id', 'strand_subjects.subject_id')
            ->join('semesters', 'semesters.id', '=', 'classes.semester_id')
            ->select('subjects.subjects as subject', 'subjects.id as id')
            ->where('semesters.status', 'active')
            ->get();

        return view('teacher.importgrades', compact('subjectClass'));
    }

    public function import(Request $request)
    {
        try {
           $validatedData = $request->validate([
    'file' => 'required|mimes:xls,xlsx',
    'subject_id' => 'required|exists:subjects,id',
    'quarter' => 'required|integer|in:1,2,',
], [
    'file.required' => 'The file field is required.',
    'file.mimes' => 'The file must be a valid Excel file (xls, xlsx).',
    'subject_id.required' => 'The subject ID field is required.',
    'subject_id.exists' => 'The selected subject is invalid.',
    'quarter.required' => 'The quarter field is required.',
    'quarter.integer' => 'The quarter must be an integer.',
    'quarter.in' => 'The quarter must be between 1 and 4.'
]);


         
            $existingStudGrades = FinalGrade::where('subject_id', $validatedData['subject_id'])
                ->where('quarter', $validatedData['quarter'])
                ->exists();

              if ($existingStudGrades) {
        return redirect()->back()->withErrors('Existing grades already recorded for this subject and quarter.');
     
    }

      $admins = User::select('email')
 ->get();

$teacher = Auth::guard('teacher')->user();


 $mailMessage = "New Grades submitted by: " . $teacher->firstname . " " . $teacher->lastname;
 $subjectMail = "Grades submitted";

foreach($admins as $admin){


     $admin->notify(new NewGradesSubmitted($subjectMail,  $mailMessage));

     

}

            Excel::import(new GradesImport($validatedData['subject_id'], $validatedData['quarter']), $request->file('file'));

            return redirect()->back()->with('success', 'Grades imported successfully');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors()->all());
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
    }
}
