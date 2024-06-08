<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\FinalGrade;
use App\Models\GradeLevel;
use App\Models\Graduate;
use App\Models\SchoolYear;
use App\Models\Section;
use App\Models\Semester;
use App\Models\Strand;
use App\Models\StrandSubject;
use App\Models\Student;
use App\Models\StudentSection;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TeacherAuthInfoController extends Controller
{
    public function advisories()
    {
        $students = $this->getAdvisoryData();
        return view('teacher.advisory', compact('students'));
    }


    public function advisoriesGrades(){

        $teacherId = Auth::guard('teacher')->user()->id;

        $students = StudentSection::join('students', 'students.id', '=', 'student_sections.student_id')
            ->join('sections', 'sections.id', '=', 'student_sections.section_id')
            ->join('final_grades', 'final_grades.student_id', '=', 'student_sections.student_id')
            ->join('subjects', 'subjects.id', '=', 'final_grades.subject_id')
            ->join('teachers', 'teachers.id', '=', 'final_grades.teacher_id')
            ->select('students.firstname as firstname', 'students.lastname as lastname', 'students.lrn as lrn',
                'students.id as id', 'student_sections.id as section_id', 'students.semester_id as semester_id', 
                'final_grades.final_grade as final_grade', 'final_grades.quarter as quarter', 'subjects.subjects as subjects', 
                'teachers.firstname as t_firstname', 'teachers.lastname as t_lastname')
               
            ->where('sections.teacher_id', $teacherId)
            ->where('students.status', 1)
            ->where('final_grades.status', 2)
            ->get();

        return view('teacher.advisoriegrades', compact('students'));

        
    }

    




public function promoteStudent($id, $section_id) {
    $student = Student::find($id);
    $section = StudentSection::find($section_id);

    if (!$student || !$section) {
        return view('error.error');
    }

    $maxSemesterId = Semester::max('id');
    $maxGradeLevelId = GradeLevel::max('id');
    $minSemesterId = Semester::min('id');

    if ($student->semester_id == $maxSemesterId) {
        $nextGradeLevelId = $student->grade_level_id + 1;
        if ($nextGradeLevelId <= $maxGradeLevelId) {
     
            $averageScore = $this->calculateAverageScore($student);

            if ($averageScore < 74) {
                return redirect()->back()->with('error', 'Student cannot be promoted due to low average score');
            }

            $student->grade_level_id = $nextGradeLevelId;
            $student->semester_id = $minSemesterId;
        } else {
          
            $schoolYear = SchoolYear::where('status', 2)->first();
            $student->status = 2;

            $graduate = new Graduate();
            $graduate->student_id = $student->id;
            $graduate->school_year_id = $schoolYear->id;
            $graduate->save();
        }
    } else {
        $student->semester_id++;
    }

    $student->save();
    $section->delete();

    return redirect()->back()->with('success', 'Student ' . $student->lrn . ' successfully promoted');
}

private function calculateAverageScore($student) {
    $selectedQuarters = [1, 2]; 

    $grades = FinalGrade::where('student_id', $student->id)
        ->whereIn('quarter', $selectedQuarters)
        ->pluck('final_grade');

    if ($grades->isEmpty()) {
        return 0; 
    }

    return $grades->avg();
}




    public function promoteAll()
{
    $teacherId = Auth::guard('teacher')->user()->id;

  
    $students = Student::join('student_sections', 'student_sections.student_id', '=', 'students.id')
    ->join('sections', 'sections.id', '=', 'student_sections.section_id')
    ->select('students.id', 'students.semester_id', 'students.grade_level_id', 'students.status')
    ->where('sections.teacher_id', $teacherId)
    ->get();


    $maxSemesterId = Semester::max('id');
    $maxGradeLevelId = GradeLevel::max('id');
    $minSemesterId = Semester::min('id');

    foreach ($students as $student) {
        
        if ($student->semester_id == $maxSemesterId) {
            $nextGradeLevelId = $student->grade_level_id + 1;
            if ($nextGradeLevelId <= $maxGradeLevelId) {
                $student->grade_level_id = $nextGradeLevelId;
                $student->semester_id = $minSemesterId;
            } else {
                $student->status = 2; 
                  $schoolYear = SchoolYear::select('id')
      ->where('status', 2)
        ->first();
              
              
           
            $student->status = 2;

            $graduate = new Graduate();
            $graduate->student_id = $student->id;
            $graduate->school_year_id = $schoolYear->id;

            $graduate->save();
            }
        } else {
            $student->semester_id++;
        }

        StudentSection::where('student_id', $student->id)->delete();
    }

    return redirect()->back()->with('success', 'All students successfully promoted.');
}


    
    public function classes()
    {
        $teacherId = Auth::guard('teacher')->user()->id;

        $classes = Classes::join('strand_subjects', 'strand_subjects.id', '=', 'classes.strand_subject_id')
            ->join('subjects', 'subjects.id', '=', 'strand_subjects.subject_id')
            ->join('sections', 'sections.id', '=', 'classes.section_id')
            ->join('strands', 'strands.id', '=', 'classes.strand_id')
            ->join('grade_levels', 'grade_levels.id', '=', 'classes.grade_level_id')
            ->join('semesters', 'semesters.id', '=', 'classes.semester_id')
            ->join('teachers', 'teachers.id', '=', 'classes.teacher_id')
            ->select('subjects.subjects as subject',
                'subjects.id as subject_id',
                'sections.section_name as section',
                'sections.id as section_id',
                'strands.strands as strand',
                'strands.id as strand_id',
                'grade_levels.level as level',
                'grade_levels.id as level_id',
                'classes.time_start as time_start',
                'classes.time_end as time_end',
                'classes.day as day',
                'classes.id as id',
                'semesters.semester as semester')
            ->where('teachers.id', $teacherId)
            ->where('semesters.status', 'active')
            ->get();

        return view('teacher.classes', compact('classes'));
    }

    public function classStudents($strand_id, $grade_level_id, $section_id, $subject_id, $class_id)
    {
        $teacherId = Auth::guard('teacher')->user()->id;

        $classes = Classes::join('strand_subjects', 'strand_subjects.id', '=', 'classes.strand_subject_id')
        ->where('classes.strand_id', $strand_id)
        
            ->where('classes.grade_level_id', $grade_level_id)
            ->where('classes.section_id', $section_id)
            ->where('classes.teacher_id', $teacherId)
            ->where('strand_subjects.subject_id', $subject_id,)
            
        
            ->first();

        if (!$classes) {
            abort(404, 'Class not found.');
        }

        $strand = Strand::find($strand_id);
        $level = GradeLevel::find($grade_level_id);
        $section = Section::find($section_id);
        $subject = Subject::find($subject_id);

        if (!$subject || !$strand || !$level || !$section) {
            abort(404, 'Not found.');
        }

        $students = Student::join('student_sections', 'students.id', '=', 'student_sections.student_id')
            ->where('students.strand_id', $strand_id)
            ->where('students.grade_level_id', $grade_level_id)
            ->where('student_sections.section_id', $section_id)
            ->select('students.id as id', 'students.lrn as lrn', 'students.firstname as firstname', 
            'students.lastname as lastname', 'students.middlename as middlename', 'students.email as email')
            ->get();

        return view('teacher.students', compact('students', 'strand', 'level', 'section', 'subject'));
    }

    private function getAdvisoryData()
    {
        $teacherId = Auth::guard('teacher')->user()->id;

        $students = StudentSection::join('students', 'students.id', '=', 'student_sections.student_id')
            ->join('sections', 'sections.id', '=', 'student_sections.section_id')
            ->select('students.firstname as firstname', 'students.lastname as lastname', 'students.lrn as lrn',
                'students.id as id', 'student_sections.id as section_id', 'students.semester_id as semester_id')
            ->where('sections.teacher_id', $teacherId)
            ->where('students.status', 1)
            ->get();

        return $students;
    }

    public function profile(){

       $id = Auth::guard('teacher')->user()->id;

        $teacher = Teacher::find($id);


        return view('teacher.profile', compact('teacher'));


    }
    public function changePassword(){

    return view('teacher.changepassword');


    }

    public function updatePassword(Request $request){

    $teacherId = Auth::guard('teacher')->user()->id;


    $teacher = Teacher::find($teacherId);

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

if(!Hash::check($validatedData['old-password'], $teacher->password)){
 
      return redirect()->back()->withErrors('The old password is incorrect');

}

 $teacher->password = Hash::make($validatedData['new-password']);
 $teacher->update();

 
 return redirect()->back()->with('success', 'Password succesfully changed');




    }

    public function changeProfile(Request $request){

        $id = Auth::guard('teacher')->user()->id;

        $teacher = Teacher::find($id);


      $validatedData = $request->validate([
    'lastname' => 'required|string|max:255',
    'firstname' => 'required|string|max:255',
    'middlename' => 'required|string|max:255',
    'birth_place' => 'required|string|max:255',
    'date_birth' => 'required|date',
    'email' => 'required|email|max:255|unique:teachers,email,' . $id,
    'phone_number' => 'nullable|string|digits_between:10,15',
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
    'birth_place.required' => 'The birth place field is required.',
    'birth_place.max' => 'The birth place may not be greater than 255 characters.',
    'date_birth.required' => 'The date of birth field is required.',
    'date_birth.date' => 'The date of birth must be a valid date.',
    'email.required' => 'The email field is required.',
    'email.email' => 'The email must be a valid email address.',
    'email.max' => 'The email may not be greater than 255 characters.',
    'email.unique' => 'The email has already been taken.',
    'phone_number.digits_between' => 'The phone number must be between 10 and 15 characters.',
    'street.max' => 'The street may not be greater than 255 characters.',
    'brgy.max' => 'The barangay may not be greater than 255 characters.',
    'city.max' => 'The city may not be greater than 255 characters.',
     'state.max' => 'The state may not be greater than 255 characters.',
    'sex.required' => 'The sex field is required.',
    'sex.in' => 'The sex field must be Male or Female.', 
    
]);


$teacher->update($validatedData);


return redirect()->back()->with('success', 'Your profile change successfully');



    }
}
