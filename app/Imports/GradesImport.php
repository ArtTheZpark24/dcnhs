<?php

namespace App\Imports;

use App\Models\FinalGrade;
use App\Models\Student;
use App\Models\Semester;
use App\Models\SchoolYear;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class GradesImport implements ToModel, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;

    protected $subjectId;
    protected $quarter;

    public function __construct($subjectId, $quarter)
    {
        $this->subjectId = $subjectId;
        $this->quarter = $quarter;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    
    {

        if (empty(array_filter($row))) {
            return null;
        }
        try {
           
            $teacherId = Auth::guard('teacher')->user()->id;

            $semester = Semester::where('status', 'active')->first();
            if (!$semester) {
                throw new \Exception('Active semester not found');
            }

            $student = Student::where('lrn', $row['lrn'])->select('grade_level_id', 'id')->first();
            if (!$student) {
                throw new \Exception('Student not found');
            }

            $schoolYear = SchoolYear::where('status', 2)->first();
            if (!$schoolYear) {
                throw new \Exception('Active school year not found');
            }

            return new FinalGrade([
                'student_id' => $student->id,
                'final_grade' => $row['final_grade'],
                'status' => 1,
                'semester_id' => $semester->id,
                'subject_id' => $this->subjectId,
                'teacher_id' => $teacherId,
                'school_year_id' => $schoolYear->id,
                'grade_level_id' => $student->grade_level_id,
                'quarter' => $this->quarter
            ]);
        } catch (\Exception $e) {
            Session::flash('error', "Error in row: " . json_encode($row) . " - " . $e->getMessage());
            return null;
        }
    }
}
