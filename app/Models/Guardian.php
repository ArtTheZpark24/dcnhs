<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Guardian extends Model implements Authenticatable
{
    use HasFactory ,SoftDeletes, AuthenticatableTrait, Notifiable;

    protected $fillable = [
        'password',
        'lastname',
        'middlename',
        'firstname',
        'phone',
        'occupation',
        'place_of_birth',
        'email',
        'birth_date',
        'street',
        'barangay',
        'city',
        'state',
        'sex'
       
    ];
   

    public function students(){

        return $this->hasMany(Student::class);
    }
}
