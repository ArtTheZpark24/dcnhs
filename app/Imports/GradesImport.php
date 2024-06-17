<?php

namespace App\Imports;

use App\Models\Classes;
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

            $semester = Semester::where('status', 'active')->firstOrFail();

            $student = Student::where('lrn', $row['lrn'])->firstOrFail();

          
            $class = $this->getClassForStudent($teacherId, $student);
            if (!$class) {
                throw new \Exception('Student ' . $student->lrn . ' does not belong to the teacher\'s assigned class for this subject.');
            }

            $schoolYear = SchoolYear::where('status', 2)->firstOrFail();

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

    /**
     * Get the class assigned to the teacher for the given student.
     *
     * @param int $teacherId
     * @param \App\Models\Student $student
     * @return \App\Models\Classes|null
     */
    private function getClassForStudent($teacherId, $student)
    {
        return Classes::join('strand_subjects', 'strand_subjects.id', '=', 'classes.strand_subject_id')
        ->join('student_sections', 'student_sections.section_id', '=', 'classes.section_id')
        ->where('student_sections.student_id', $student->id)
        ->where('classes.teacher_id',$teacherId)
        ->first();
           
    }
}
