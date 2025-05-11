<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function update_profile(User $user, Request $request) {
      if ($request->password) {
        $request->validate([
          'fullname' => 'required|string',
          'username' => 'required|string',
          'password' => 'string|confirmed',
        ]);

        $user->update([
          'fullname' => $request->fullname,
          'username' => $request->username,
          'password' => Hash::make($request->password),
        ]);

      } else {
        $request->validate([
          'fullname' => 'required|string',
          'username' => 'required|string'
        ]);

        $user->update([
          'fullname' => $request->fullname,
          'username' => $request->username,
        ]);
      }

      if (!$request->password && $request->password_confirmation) {
        $request->validate([
          'password' => 'required'
        ]);
      }

      return response()->json([
        'message' => 'Your account updated successfully',
        'user' => $user->fresh()->makeHidden(['password', 'token']),
      ]);
    }
}
