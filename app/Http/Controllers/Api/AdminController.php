<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
  public function get_users(Request $request) {
    $all_users = User::where('id', '!=', $request->user()->id)->latest()->get();


    return response()->json([
      'data' => $all_users,
    ]);
  }

  public function create_user(Request $request) {
    $request->validate([
      'fullname' => 'required|string',
      'username' => 'required|string',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|string',
    ]);

    $user = User::create([
        'fullname' => $request->fullname,
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'non-admin',
        'is_active' => true,
        'is_verified' => true,
        'is_approved' => true
    ]);

    return response()->json([
        'message' => "You have created {$user->username} account",
    ], 201);
  }


  public function approve_email(User $user) {
    $user->update([
      'is_approved' => true,
    ]);

    return response()->json([
      'message' => "You have approved {$user->user} account",
    ], 200);
  }

  public function disapprove_email(User $user) {
    $user->update([
      'is_approved' => false,
    ]);

    return response()->json([
      'message' => "You have disapproved {$user->user} account",
    ], 200);
  }

  
  public function deactivate_account(User $user) {
    $user->update([
      'is_active' => false,
    ]);

    return response()->json([
      'message' => "You have deactivated {$user->username} account",
    ], 200);
  }

  public function activate_account(User $user) {
    $user->update([
      'is_active' => true,
    ]);

    return response()->json([
      'message' => "You have activated {$user->username} account",
    ], 200);
  }

  public function change_role(User $user, Request $request) {
    $request->validate([
      'status' => 'required|string',
    ]);
  
    if ($request->status === 'staff') {
      $user->update([
        'role' => 'non-admin',
      ]);

      return response()->json([
        'message' => "You have changed the role of {$user->username} account to staff",
      ]);
    }
  
    $user->update([
      'role' => 'admin',
    ]);

    return response()->json([
      'message' => "You have changed the role of {$user->username} account to admin",
    ], 200);
  }
}
