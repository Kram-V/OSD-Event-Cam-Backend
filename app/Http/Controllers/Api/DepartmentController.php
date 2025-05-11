<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\EducationLevel;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function departments() {
      $departments = Department::latest()->get();

      return response()->json([
        'departments' => $departments,
      ]);
    }

    public function create_department(Request $request) {
      $request->validate([
        'education_level' => "required|integer",
        'name' => 'required|string',
      ]);

      $education_level = EducationLevel::where('id', $request->education_level)->first();

      if (!$education_level) {
        return response()->json([ 
          'message' => 'There is no education level id that you are inserting to',
        ], 404);
      }

      Department::create([
        'education_level_id' => $request->education_level,
        'name' => $request->name,
      ]);

      return response()->json([
        'message' => 'Department Created Successfully',
      ], 201);
    }

    public function update_department(Department $department, Request $request) {
      $request->validate([
        'education_level' => "required|integer",
        'name' => 'required|string',
      ]);

      $education_level = EducationLevel::where('id', $request->education_level)->first();

      if (!$education_level) {
        return response()->json([ 
          'message' => 'There is no education level id that you are updating to',
        ], 404);
      }

      $department->update([
        'education_level_id' => $request->education_level,
        'name' => $request->name,
      ]);

      return response()->json([
        'message' => 'Department Updated Successfully',
      ], 200);
    }

}
