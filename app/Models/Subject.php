<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [

        'subjects',
        'strand_id',
        'grade_level_id',
        'semester_id'
       
    ];

   

  
   
 



   public function strand(){
    return $this->belongsTo(Strand::class, 'strand_id');
   }
    
   public function semester()
   {
       return $this->belongsTo(Semester::class, 'semester_id');
   }

   public function classes()
    {
        return $this->hasMany(Classes::class);
    }
  
}
