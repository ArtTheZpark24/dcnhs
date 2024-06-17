<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Guardian;

class UserAllControllerr extends Controller
{

    
    public function index()
    {
        $users = [];

        $admins = User::all();
        foreach ($admins as $admin) {
            $users[] = [
                'id' => $admin->id,
                'name' => $admin->name,
                'role' => 'admin'
            ];
        }

        $students = Student::all();
        foreach ($students as $student) {
            $users[] = [
                'id' => $student->id,
                'name' => $student->name,
                'role' => 'student'
            ];
        }

        $teachers = Teacher::all();
        foreach ($teachers as $teacher) {
            $users[] = [
                'id' => $teacher->id,
                'name' => $teacher->name,
                'role' => 'teacher'
            ];
        }

        $guardians = Guardian::all();
        foreach ($guardians as $guardian) {
            $users[] = [
                'id' => $guardian->id,
                'name' => $guardian->name,
                'role' => 'guardian'
            ];
        }

        return view('admin.allusers', compact('users'));
    }
}
