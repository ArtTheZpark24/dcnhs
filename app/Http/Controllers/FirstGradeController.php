<?php

namespace App\Http\Controllers;


use App\Mail\GradesSubmitted;
use App\Models\Assesment;
use App\Models\Classes;
use App\Models\FinalGrade;
use App\Models\PerformanceTask;
use App\Models\SchoolYear;
use App\Models\Semester;
use App\Models\Student;
use App\Models\StudentSection;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use App\Models\WrittenWork;
use App\Notifications\NewGradesSubmitted;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class FirstGradeController extends Controller
{
    public function index($student_id, $subject_id)
    {
       
       $teacherId = Auth::guard('teacher')->user()->id;

    $class = Classes::join('strand_subjects', 'strand_subjects.id', '=', 'classes.strand_subject_id')
                    ->join('grade_levels', 'grade_levels.id', '=', 'classes.grade_level_id')
                    ->join('strands', 'strands.id', '=', 'classes.strand_id')
                    ->where('strand_subjects.subject_id', $subject_id)
                    ->where('classes.teacher_id', $teacherId)
                    ->select('grade_levels.id as grade_level_id', 'strands.id as strand_id', 'classes.section_id as section_id')
                    ->first();

                   

                   

    if (!$class) {
       abort(403, 'Unauthorized access');
    }
 $student = Student::join('grade_levels', 'grade_levels.id', '=', 'students.grade_level_id')
                      ->join('strands', 'strands.id', '=', 'students.strand_id')
                       ->join('student_sections', 'student_sections.student_id', '=', 'students.id')
                       
                      ->where('students.grade_level_id', $class->grade_level_id)
                      ->where('students.strand_id', $class->strand_id)
                      ->where('students.id', $student_id)
                      ->where('student_sections.section_id',$class->section_id )
                      ->first();

    if (!$student) {
        abort(403, 'Unauthorized access');
    }


   
    
         $student = Student::find($student_id);
        $subject = Subject::find($subject_id);

         if (!$subject || !$student) {
            return view('error.error');
        }


   
        $grades = [];
    

        for ($quarter = 1; $quarter <= 2; $quarter++) {
      
            $writtenWorks = WrittenWork::select('ps', 'ws')
                ->where('student_id', $student_id)
                ->where('subject_id', $subject_id)
                ->where('quarter', $quarter)
                ->get();
    
  
            $performanceTasks = PerformanceTask::select('ps', 'ws')
                ->where('student_id', $student_id)
                ->where('subject_id', $subject_id)
                ->where('quarter', $quarter)
                ->get();
    
          
            $assessments = Assesment::select('ps', 'ws')
                ->where('student_id', $student_id)
                ->where('subject_id', $subject_id)
                ->where('quarter', $quarter)
                ->get();
    
      
            $initialGrade = $writtenWorks->sum('ws') + $performanceTasks->sum('ws') + $assessments->sum('ws');
    
      
            
    $gradeScale = [
                ['min' => 98.40, 'max' => 99.99, 'final_grade' => 99],
                ['min' => 96.80, 'max' => 98.39, 'final_grade' => 98],
                ['min' => 95.20, 'max' => 96.79, 'final_grade' => 97],
                ['min' => 93.60, 'max' => 95.19, 'final_grade' => 96],
                ['min' => 92.00, 'max' => 93.59, 'final_grade' => 95],
                ['min' => 90.40, 'max' => 91.99, 'final_grade' => 94],
                ['min' => 88.80, 'max' => 90.39, 'final_grade' => 93],
                ['min' => 87.20, 'max' => 88.79, 'final_grade' => 92],
                ['min' => 85.60, 'max' => 87.19, 'final_grade' => 91],
                ['min' => 84.00, 'max' => 85.59, 'final_grade' => 90],
                ['min' => 82.40, 'max' => 83.99, 'final_grade' => 89],
                ['min' => 80.80, 'max' => 82.39, 'final_grade' => 88],
                ['min' => 79.20, 'max' => 80.79, 'final_grade' => 87],
                ['min' => 77.60, 'max' => 79.19, 'final_grade' => 86],
                ['min' => 76.00, 'max' => 77.59, 'final_grade' => 85],
                ['min' => 74.40, 'max' => 75.99, 'final_grade' => 84],
                ['min' => 72.80, 'max' => 74.39, 'final_grade' => 83],
                ['min' => 71.20, 'max' => 72.79, 'final_grade' => 82],
                ['min' => 69.60, 'max' => 71.19, 'final_grade' => 81],
                ['min' => 68.00, 'max' => 69.59, 'final_grade' => 80],
                ['min' => 61.60, 'max' => 63.19, 'final_grade' => 76],
                ['min' => 60.00, 'max' => 61.59, 'final_grade' => 75],
                ['min' => 56.00, 'max' => 59.99, 'final_grade' => 74],
                ['min' => 52.00, 'max' => 55.99, 'final_grade' => 73],
                ['min' => 48.00, 'max' => 51.99, 'final_grade' => 72],
                ['min' => 44.00, 'max' => 47.99, 'final_grade' => 71],
                ['min' => 40.00, 'max' => 43.99, 'final_grade' => 70],
                ['min' => 36.00, 'max' => 39.99, 'final_grade' => 69],
                ['min' => 32.00, 'max' => 35.99, 'final_grade' => 68],
                ['min' => 28.00, 'max' => 31.99, 'final_grade' => 67],
                ['min' => 24.00, 'max' => 27.99, 'final_grade' => 66],
                ['min' => 20.00, 'max' => 23.99, 'final_grade' => 65],
                ['min' => 16.00, 'max' => 19.99, 'final_grade' => 64],
                ['min' => 12.00, 'max' => 15.99, 'final_grade' => 63],
                ['min' => 8.00, 'max' => 11.99, 'final_grade' => 62],
                ['min' => 4.00, 'max' => 7.99, 'final_grade' => 61],
                ['min' => 0, 'max' => 3.99, 'final_grade' => 60]
            ];
        
          
            $finalGrade = 60;
    
       
            foreach ($gradeScale as $range) {
                if ($initialGrade >= $range['min'] && $initialGrade <= $range['max']) {
                    $finalGrade = $range['final_grade'];
                    break;
                }
            }
    
         
            $grades[$quarter] = [
                'initialGrade' => $initialGrade,
                'finalGrade' => $finalGrade,
            ];

               $grades[$quarter] = [
                'initialGrade' => $initialGrade,
                'finalGrade' => $finalGrade,
            ];
        }
    
        return view('teacher.studentgrades', compact('student', 'subject', 'grades'))
            ->with('success', 'Grades Successfully sent to admin');
    }
    
   public function saveGrades(Request $request, $student_id, $subject_id,){

    $student = Student::find($student_id);
    $subject = Subject::find($subject_id);


 $validatedData = $request->validate([

    'initial_grade' => 'required|numeric', 
    'final_grade' => 'required|numeric',   
    'quarter' => 'required',        
 
 
 ]   );

 $existingStudGrades = FinalGrade::where('student_id', $student->id)
 ->where('subject_id', $subject_id)
 ->where('quarter', $validatedData['quarter'])
 ->exists();

if ($existingStudGrades) {
 return redirect()->back()->withErrors('This Quarter Grades already exist for this student.');

}
   

 $semester = Semester::select('id')
 ->where('status', 'active')
 ->first();

 $schoolYear = SchoolYear::select('id')
 ->where('status', 2)
 ->first();

 $admins = User::select('email')
 ->get();

$teacher = Auth::guard('teacher')->user();


$message['grades'] = "New Grades submitted by: " . $teacher->firstname . " " . $teacher->lastname;
$subjectMail = 'New Grades Submit';

foreach($admins as $admin){

  

     $admin->notify(new NewGradesSubmitted($message, $subjectMail));


     

}
   


 $finalGrade = new FinalGrade();

 $finalGrade = new FinalGrade();
        $finalGrade->student_id = $student->id;
        $finalGrade->subject_id = $subject->id;
        $finalGrade->school_year_id = $schoolYear->id;
        $finalGrade->grade_level_id = $student->grade_level_id;
        $finalGrade->semester_id =  $semester->id;
        $finalGrade->teacher_id = Auth::guard('teacher')->user()->id;
        $finalGrade->initial_grade = $validatedData['initial_grade'];
        $finalGrade->final_grade = $validatedData['final_grade'];
        $finalGrade->quarter = $validatedData['quarter'];
        $finalGrade->status = 1;
        $finalGrade->save();

        return redirect()->back()->with('success', 'Final grade recorded successfully!');


    
   }

 
   
}
