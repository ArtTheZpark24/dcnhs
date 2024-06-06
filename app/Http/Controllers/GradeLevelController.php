<?php

namespace App\Http\Controllers;

use App\Models\GradeLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeLevelController extends Controller
{
    //



    public function gradeLevelPost(Request $request){

        $validatedData = $request->validate([
            'level' => 'required|integer|unique:grade_levels,level'

        ], [
            'level.required' => 'The Grade level field is required.',
            'level.integer' => 'The Grade field must be an integer.'
        ]);
        
        GradeLevel::create($validatedData);

        return redirect()->back()->with('success', 'Grade Level Created');
        
    }

    public function update(Request $request, $id){


        $gradeLevel = GradeLevel::find($id);

        $validatedData = $request->validate([
            'level' => 'required|integer|unique:grade_levels,level'

        ], [
            'level.unique' => 'The Grade level already exists in the grade levels.',
            'level.required' => 'The Grade level field is required.',
            'level.integer' => 'The Grade field must be an integer.'
        ]);
        
        $gradeLevel->update($validatedData);

        return redirect()->back()->with('success', 'Grade Level Successfuly update');
        
    }

    public function delete($id){


        $gradeLevel = GradeLevel::find($id);

        $gradeLevel->delete();

        return redirect()->back()->with('success', 'Grade Level Successfuly delete');


    }
}
