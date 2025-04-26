<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
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

Route::middleware('auth:sanctum')->group(function() {
  Route::post('/logout', [AuthController::class, 'logout']);

  Route::get('/get-users', [AdminController::class, 'get_users']);

  Route::post('/create-user', [AdminController::class, 'create_user']);

  Route::put('/approve-email/{user}', [AdminController::class, 'approve_email']);
  Route::put('/disapprove-email/{user}', [AdminController::class, 'disapprove_email']);
  Route::put('/deactivate-account/{user}', [AdminController::class, 'deactivate_account']);
  Route::put('/activate-account/{user}', [AdminController::class, 'activate_account']);
  Route::put('/change-role/{user}', [AdminController::class, 'change_role']);

  Route::put('/update-profile/{user}', [ProfileController::class, 'update_profile']);
});



