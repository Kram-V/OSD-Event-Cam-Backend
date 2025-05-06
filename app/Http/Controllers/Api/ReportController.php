<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Program;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function create_report(Request $request) {
      $request->validate([
        "department_id" => 'required|integer',
        "program_id" => 'required|integer',
        "student_name" => 'required|string',
        "student_id" => 'required|string',
        "time" => 'required|string',
        "location" => 'required|string',
        "violation_name" => 'required|string',
        "violations" => 'nullable|json',
        "other_violation_name" => 'nullable|string',
        "explain_specify" => 'nullable|string',
        "other_remarks" => 'nullable|string',
        "photo_evidence" => 'nullable|string',
      ]);

      Report::create([
        "department_id" => $request->department_id,
        "program_id" => $request->program_id,
        "student_name" => $request->student_name,
        "student_id" => $request->student_id,
        "time" => $request->time,
        "location" => $request->location,
        "violation_name" => $request->violation_name,
        "violations" => $request->violations,
        "other_violation_name" => $request->other_violation_name,
        "explain_specify" => $request->explain_specify,
        "other_remarks" => $request->other_remarks,
        "photo_evidence" => $request->photo_evidence,
      ]);

      return response()->json([
        'message' => 'Report Created Successfully',
      ]);
    }

    public function departments() {
      $departments = Department::all();

      return response()->json([
        'departments' => $departments,
      ]);
    }

    public function programs($department_id) {
      $programs = Program::where('department_id', $department_id)->get();

      return response()->json([
        'programs' => $programs,
      ]);
    }
}
