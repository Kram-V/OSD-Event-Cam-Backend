<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\WebsiteMail;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
      $request->validate([
        'fullname' => 'required|string',
        'username' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|confirmed',
      ]);

      $verification_token = hash('sha256', time());

      $user = User::create([
          'fullname' => $request->fullname,
          'username' => $request->username,
          'email' => $request->email,
          'password' => Hash::make($request->password),
          'role' => 'non-admin',
          'token' => $verification_token,
          'is_active' => true,
          'is_verified' => false,
          'is_approved' => false
      ]);
      
      $verification_link = route('verify_email', ['token' => $user->token, 'email' => $user->email]);

      $subject = 'User Account Verification';
      $content = "To verify your email, please click on the link: <a href='{$verification_link}'>Click Here</a>";

      Mail::to($user->email)->send(new WebsiteMail($subject, $content));

      return response()->json([
          'message' => 'You have created your account',
      ], 201);
    }


    public function login(Request $request)
    {
      $request->validate([
          'email' => 'required|email',
          'password' => 'required|string',
      ]);

      if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
          $user = Auth::user();

          if (!$user->is_approved && !$user->is_verified) {
            throw ValidationException::withMessages([
              'message' => 'Please make sure your email is verified and approved by admin',
            ]);
          }

          if (!$user->is_active) {
            throw ValidationException::withMessages([
              'message' => 'Your account is not active currently, please contact your admin.',
            ]);
          }

          if (!$user->is_approved) {
            throw ValidationException::withMessages([
              'message' => 'Your account is not approved by an admin, please contact your admin.',
            ]);
          }

          if (!$user->is_verified) {
            throw ValidationException::withMessages([
              'message' => 'Please verify first your email before you login',
            ]);
          }

          $token = $user->createToken('osd-event-cam')->plainTextToken;

          $user->makeHidden(['token']);

          return response()->json([
              'user' => $user,
              'token' => $token,
          ], 200);
      }

      throw ValidationException::withMessages([
          'email' => 'The provided credentials are incorrect.',
      ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        $user->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged Out Successfully',
        ], 200);
    }

    public function verify_email($token, $email) {
      $user = User::where(['email' => $email, 'token' => $token])->first();
  
      if (!$user) {
        throw ValidationException::withMessages([
          'message' => 'There is something wrong with the verification of your email',
        ]);
      }
  
      $user->update([
        'token' => null,
        'is_verified' => true,
      ]);
  
      return view('email-verified');
    }  

    public function reset_password(Request $request, $token, $email) {
      $request->validate([
        'password' => 'required|string|confirmed',
      ]);

      $user = User::where(['token' => $token, 'email' => $email])->first();

      if (!$user) {
        throw ValidationException::withMessages([
          'message' => "It might be your token has a problem or email is not existing",
        ]);
      }

      $user->update([
        'password' => Hash::make($request->password),
        'token' => null,
      ]);

      return response()->json([
        'message' => 'You have changed your password successfully',
      ], 200);
    }

    public function forgot_password(Request $request) {
      $request->validate([
        'email' => 'required|email',
      ]);

      $user = User::where('email', $request->email)->first();

      if (!$user) {
        throw ValidationException::withMessages([
          'message' => 'The email you provided is not existing',
        ]);
      }

      if (!$user->is_approved && !$user->is_verified) {
        throw ValidationException::withMessages([
          'message' => 'Please make sure your email is verified and approved by admin',
        ]);
      }

      if (!$user->is_active) {
        throw ValidationException::withMessages([
          'message' => 'Your account is not active currently, please contact your admin before you reset the password.',
        ]);
      }

      if (!$user->is_approved) {
        throw ValidationException::withMessages([
          'message' => 'Your account is not approved by an admin, please contact your admin before you reset the password.',
        ]);
      }

      if (!$user->is_verified) {
        throw ValidationException::withMessages([
          'message' => 'Please verify first your email before you reset the password',
        ]);
      }

      $reset_password_token = hash('sha256', time());

      $user->update([
        'token' => $reset_password_token,
      ]);

      $reset_link = "http://localhost:3000/reset-password/{$user->token}/{$user->email}";
      $subject = "Password Reset";
      $content = "To reset password, please click on the link: <a href='{$reset_link}'>Click Here</a>";
  
      Mail::to($request->email)->send(new WebsiteMail($subject, $content));

      return response()->json([
        'message' => 'You have submitted your email, please check your email and click the link for resetting the password',
      ], 201);
    }
}
