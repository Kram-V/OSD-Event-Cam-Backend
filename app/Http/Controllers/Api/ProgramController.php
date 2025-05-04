<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function programs() {
      $programs = Program::with('department')->latest()->get();

      return response()->json([
        'programs' => $programs,
      ]);
    }

    public function create_program(Request $request) {
      $request->validate([
        'department' => 'required|integer',
        'name' => 'required|string',
      ]);

      $department = Department::where('id', $request->department)->first();

      if (!$department) {
        return response()->json([
          'message' => 'There is no department id that you are inserting to',
        ], 404);
      }

      Program::create([
        'department_id' => $request->department,
        'name' => $request->name,
        'code' => $request->code,
        'description' => $request->description,
      ]);

      return response()->json([
        'message' => 'Program Created Successfully',
      ], 201);
    }

    public function update_program(Program $program, Request $request) {
      $request->validate([
        'department' => 'required|integer',
        'name' => 'required|string',
      ]);

      $department = Department::where('id', $request->department)->first();

      if (!$department) {
        return response()->json([
          'message' => 'There is no department id that you are inserting to',
        ], 404);
      }

      
      $program->update([
        'department_id' => $request->department,
        'name' => $request->name,
        'code' => $request->code,
        'description' => $request->description,
      ]);

      return response()->json([
        'message' => 'Program Updated Successfully',
      ], 200);
    }
}
