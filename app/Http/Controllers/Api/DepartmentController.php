<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
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
        'name' => 'required|string',
      ]);

      Department::create([
        'name' => $request->name,
      ]);

      return response()->json([
        'message' => 'Department Created Successfully',
      ], 201);
    }

    public function update_department(Department $department, Request $request) {
      $request->validate([
        'name' => 'required|string',
      ]);

      $department->update([
        'name' => $request->name,
      ]);

      return response()->json([
        'message' => 'Department Updated Successfully',
      ], 200);
    }

}
