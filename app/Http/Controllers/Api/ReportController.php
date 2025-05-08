<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Program;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function reports() {
      $reports = Report::all();

      return response()->json([
        'reports' => $reports,
      ]);
    }

    public function report($id) {
      $report = Report::with(['department', 'program'])->where('id', $id)->first();

      return response()->json([
        'report' => $report,
      ]);
    }

    public function mark_as_resolved_report(Report $report) {
      $report->update([
        'status' => 'success',
      ]);

      return response()->json([
        'message' => 'Report Marked as Resolved',
      ]);
    }


    public function create_report(Request $request) {
      $request->validate([
        "department" => 'required|integer',
        "program" => 'required|integer',
        "student_name" => 'required|string',
        "student_id" => 'required|string',
        "year" => 'required|string',
        "section" => 'required|string',
        "guardian_name" => 'required|string',
        "guardian_phone_number" => 'required|string|regex:/^09\d{9}$/',
        "time" => 'required|string',
        "location" => 'required|string',
        "violation_name" => 'required|string',
        "violations" => 'nullable|json',
      ]);

      Report::create([
        "department_id" => $request->department,
        "program_id" => $request->program,
        "student_name" => $request->student_name,
        "student_id" => $request->student_id,
        "year" => $request->year,
        "section" => $request->section,
        "guardian_name" => $request->guardian_name,
        "guardian_phone_number" => $request->guardian_phone_number,
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
      ], 201);
    }

    public function departments() {
      $departments = Department::all();

      return response()->json([
        'departments' => $departments,
      ], 200);
    }

    public function programs($department_id) {
      $programs = Program::where('department_id', $department_id)->get();

      return response()->json([
        'programs' => $programs,
      ], 200);
    }
}
