<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EducationLevel;
use Illuminate\Http\Request;

class EducationLevelController extends Controller
{
    public function education_levels() {
      $education_levels = EducationLevel::latest()->get();

      return response()->json([
        'education_levels' => $education_levels,
      ]);
    }

    public function create_education_level(Request $request) {
      $request->validate([
        'name' => 'required|string',
      ]);

      EducationLevel::create([
        'name' => $request->name,
      ]);

      return response()->json([
        'message' => 'Education Level Created Successfully',
      ], 201);
    }

    public function update_education_level(EducationLevel $education_level, Request $request) {
      $request->validate([
        'name' => 'required|string',
      ]);
      
      $education_level->update([
        'name' => $request->name,
      ]);

      return response()->json([
        'message' => 'Education Level Updated Successfully',
      ], 200);
    }
}
