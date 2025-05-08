<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserInstruction;
use Illuminate\Http\Request;

class UserInstructionController extends Controller
{
    public function user_instructions() {
      $user_instructions = UserInstruction::all();

      return response()->json([
        'user_instructions' => $user_instructions, 
      ], 200);
    }

    public function create_instruction(Request $request) {
      $request->validate([
        'instruction_name' => 'required|string',
        'description' => 'required|string',
      ]);


      UserInstruction::create([
        'instruction_name' => $request->instruction_name,
        'description' => $request->description,
      ]);

      return response()->json([
        'message' => 'User Instruction Created Successfully',
      ], 201);
    }

    public function update_instruction($id, Request $request) {
      $request->validate([
        'instruction_name' => 'required|string',
        'description' => 'required|string',
      ]);

      $user_instruction = UserInstruction::where('id', $id)->first();


      if (!$user_instruction) {
        return response()->json([
          'message' => 'User Instruction Not Found',
        ], 404);
      }

      $user_instruction->update([
        'instruction_name' => $request->instruction_name,
        'description' => $request->description,
      ]);

      return response()->json([
        'message' => 'User Instruction Updated Successfully',
      ], 200);
    }

    public function delete_instruction($id) {
      $user_instruction = UserInstruction::where('id', $id)->first();

      if (!$user_instruction) {
        return response()->json([
          'message' => 'User Instruction Not Found',
        ], 404);
      }

      $user_instruction->delete();

      return response()->json([
        'message' => 'User Instuction Deleted Successfully',
      ]);
    }
}
