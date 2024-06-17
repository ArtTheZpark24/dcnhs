<?php

namespace App\Imports;

use App\Models\GradeLevel;
use App\Models\Student;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;

class StudentsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Get the default grade level ID from the database or set it manually
        $defaultGradeLevelId = 1; // Set your default grade level ID here

     
        
        
        dd($row);
    }
}
