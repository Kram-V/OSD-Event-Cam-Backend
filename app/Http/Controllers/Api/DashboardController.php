<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats() {
      $admin_users = User::where('role', 'admin')->count();
      $non_admin_users = User::where('role', 'non-admin')->count();

      return response()->json([
        'total_admin_users' => $admin_users,
        'total_non_admin_users' => $non_admin_users
      ]);
    }
}
