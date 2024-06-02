<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinalGrade extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'subject_id',
        'teacher_id',
        'initial_grade',
        'final_grade',
        'status',
        'quarter',
        'semester_id',
        'school_year_id',
        'grade_level_id'
    ];



}
