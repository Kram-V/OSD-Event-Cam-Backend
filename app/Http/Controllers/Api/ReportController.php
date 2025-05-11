<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\EducationLevel;
use App\Models\Program;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function reports(Request $request) {
      if ($request->query('educational_id') == 'all') {
        $reports = Report::with(['education_level', 'program'])->get();
      } else if($request->query('educational_id')) {
        $reports = Report::with(['education_level', 'program'])->where('education_level_id', (int) $request->query('educational_id'))->get();
      } else {
        $reports = Report::with(['education_level', 'program'])->get();
      }

      return response()->json([
        'reports' => $reports,
      ]);
    }

    public function report($id) {
      $report = Report::with(['department', 'program', 'education_level'])->where('id', $id)->first();

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

    public function mobile_reports() {
      $reports = Report::all();

      return response()->json([
        'reports' => $reports,
      ]);
    }

    public function create_report(Request $request) {
      $request->validate([
        "education_level" => "required|integer",
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
        "education_level_id" => $request->education_level,
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

 
    public function departments($education_level_id) {
      $departments = Department::where('education_level_id', $education_level_id)->get();

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
