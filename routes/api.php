<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\HelpController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ProgramController;
use App\Http\Controllers\Api\ReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgot_password']);
Route::post('/reset-password/{token}/{email}', [AuthController::class, 'reset_password']);

Route::get('/mobile-stats', [DashboardController::class, 'mobile_stats']);

Route::get('/mobile-departments', [ReportController::class, 'departments']);
Route::get('/mobile-programs/{department_id}', [ReportController::class, 'programs']);
Route::post('/mobile-reports', [ReportController::class, 'create_report']);

Route::middleware('auth:sanctum')->group(function() {
  Route::post('/logout', [AuthController::class, 'logout']);

  Route::get('/get-users', [AdminController::class, 'get_users']);

  Route::post('/create-user', [AdminController::class, 'create_user']);

  Route::put('/approve-email/{user}', [AdminController::class, 'approve_email']);
  Route::put('/disapprove-email/{user}', [AdminController::class, 'disapprove_email']);
  Route::put('/deactivate-account/{user}', [AdminController::class, 'deactivate_account']);
  Route::put('/activate-account/{user}', [AdminController::class, 'activate_account']);
  Route::put('/change-role/{user}', [AdminController::class, 'change_role']);

  Route::post('/contact-form', [HelpController::class, 'contact_form']);

  Route::get('/stats', [DashboardController::class, 'stats']);

  Route::put('/update-profile/{user}', [ProfileController::class, 'update_profile']);

  Route::get('/departments', [DepartmentController::class, 'departments']);
  Route::post('/departments', [DepartmentController::class, 'create_department']);
  Route::put('/departments/{department}', [DepartmentController::class, 'update_department']);

  Route::get('/programs', [ProgramController::class, 'programs']);
  Route::post('/programs', [ProgramController::class, 'create_program']);
  Route::put('/programs/{program}', [ProgramController::class, 'update_program']);

  Route::get('/faqs', [FaqController::class, 'faqs']);
  Route::post('/faqs', [FaqController::class, 'create_faq']);
  Route::put('/faqs/{faq}', [FaqController::class, 'update_faq']);
  Route::delete('/faqs/{id}', [FaqController::class, 'delete_faq']);
});



