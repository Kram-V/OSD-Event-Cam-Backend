<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats() {
      $admin_users = User::where('role', 'admin')->count();
      $non_admin_users = User::where('role', 'non-admin')->count();
      $total_reports = Report::all()->count();

      return response()->json([
        'total_admin_users' => $admin_users,
        'total_non_admin_users' => $non_admin_users,
        'total_reports' => $total_reports
      ]);
    }

    public function mobile_stats() {
      $admin_users = User::where('role', 'admin')->count();
      $non_admin_users = User::where('role', 'non-admin')->count();
      $total_reports = Report::all()->count();

      return response()->json([
        'total_admin_users' => $admin_users,
        'total_non_admin_users' => $non_admin_users,
        'total_reports' => $total_reports
      ]);
    }

    public function mobile_reports() {
      $reports = Report::all();

      return response()->json([
        'reports' => $reports,
      ]);
    }
}
