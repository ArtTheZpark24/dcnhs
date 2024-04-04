<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    protected $fillable = [
        'strand_subject_id',
        'section_id',
        'teacher_id',
        'semester_id',
        'grade_level_id',
        'day',
        'time_start',
        'time_end',
    ];


  
    public function subject(){

        return $this->belongsToMany(Subject::class, 'subject_id');
    }

    public function studentclass(){

    return $this->belongsTo(Student::class);

    }

  

    public function strandSub(){

    return $this->hasMany(StrandSubject::class,  'strand_subject_id',);


    }

    public function section(){

        return $this->belongsTo(Section::class, 'section_id');
    }


    public function teacher(){

        return $this->hasMany(Teacher::class, 'teacher_id');
    }

    public function semester(){

        return $this->belongsTo(Semester::class, 'semester_id');
  
      }

      public function gradeLevel(){

        return $this->belongsTo(Semester::class, 'grade_level_id');
  
      }
}
