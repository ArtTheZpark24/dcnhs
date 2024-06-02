<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $fillable = [
        'lrn',
        'password',
        'lastname',
        'firstname',
        'middlename',
        'sex',
        'strand_id',
        'grade_level_id',
        'place_birth',
        'date_birth',
        'email',
        'street',
        'brgy',
        'city',
        'semester_id',
        'state',
        'user_id'
    ];

    public function strands()
    {
        return $this->belongsTo(Strand::class, 'strand_id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class, 'section_id');
    }

    public function guardians()
    {
        return $this->belongsTo(Guardian::class, 'guardian_id');
    }

    public function studentclass()
    {
        return $this->belongsTo(Studentclass::class);
    }

    public function gradeLevel()
    {
        return $this->hasOne(GradeLevel::class);
    }
   
}