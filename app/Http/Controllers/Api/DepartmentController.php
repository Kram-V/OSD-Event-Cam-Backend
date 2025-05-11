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
        'education_level_name' => "required|string",
        'name' => 'required|string',
      ]);


      Department::create([
        'education_level_name' => $request->education_level_name,
        'name' => $request->name,
      ]);

      return response()->json([
        'message' => 'Department Created Successfully',
      ], 201);
    }

    public function update_department(Department $department, Request $request) {
      $request->validate([
        'education_level_name' => "required|string",
        'name' => 'required|string',
      ]);

      $department->update([
        'education_level_name' => $request->education_level_name,
        'name' => $request->name,
      ]);

      return response()->json([
        'message' => 'Department Updated Successfully',
      ], 200);
    }

}
