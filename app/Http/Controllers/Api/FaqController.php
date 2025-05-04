<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function faqs() {
      $faqs = Faq::all();

      return response()->json([
        'faqs' => $faqs,
      ]);
    }

    public function create_faq(Request $request) {
      $request->validate([
        'question' => 'required',
        'description' => 'required',
      ]);

      Faq::create([
        'question' => $request->question,
        'description' => $request->description,
      ]);

      return response()->json([
        'message' => 'You have created faq successfully',
      ]);
    }

    public function update_faq(Faq $faq, Request $request) {
      $request->validate([
        'question' => 'required',
        'description' => 'required',
      ]);

      $faq->update([
        'question' => $request->question,
        'description' => $request->description,
      ]);

      return response()->json([
        'message' => 'You have updated faq successfully',
      ]);
    }

    public function delete_faq($id) {

      $faq = Faq::find($id);
  
      if (!$faq) {
        return response()->json([
          'message' => 'The faq that you wanted to delete is not existing',
        ], 404);
      }

      $faq->delete();

      return response()->json([
        'message' => 'You have deleted faq successfully',
      ]);
    }
}
