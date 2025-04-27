<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\WebsiteMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HelpController extends Controller
{
    public function contact_form(Request $request) {
      $request->validate([
        'message' => 'required|string'
      ]);

      $adminEmails = User::where([
          ['role', 'admin'], ['email', '!=', 'markanthonyvivar24@gmail.com']
        ])->get();


      $subject = "Technical Support Request";
      $content = "
        <p><b>Fullname:</b> {$request->fullname}</p>
        <p><b>Email:</b> {$request->email}</p>
        <p><b>Message:</b> {$request->message}</p>
      ";

      Mail::to('markanthonyvivar24@gmail.com')
      ->cc($adminEmails) 
      ->send(new WebsiteMail($subject, $content)); 

      return response()->json([
        'message' => 'You have sent your message',
      ], 201);
    }
}
