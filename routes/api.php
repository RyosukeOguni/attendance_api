<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StampController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\SchoolController;
use App\Http\Controllers\Api\NoteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// 打刻
Route::get('stamp', [StampController::class, 'index']);
Route::post('stamp', [StampController::class, 'store']);
Route::put('stamp/{id}', [StampController::class, 'update']);
// 所属校
Route::get('schools', [SchoolController::class, 'index']);
// 備考
Route::get('notes', [NoteController::class, 'index']);
// ログイン
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);

// 管理者権限
Route::middleware('auth:sanctum')->group(function () {
  // 利用者管理
  Route::get('users', [UserController::class, 'index']);
  Route::post('users', [UserController::class, 'store']);
  Route::get('users/{id}', [UserController::class, 'show']);
  Route::put('users/{id}', [UserController::class, 'update']);
  Route::delete('users/{id}', [UserController::class, 'destroy']);
  // 出欠記録管理
  Route::get('attendances', [AttendanceController::class, 'index']);
  Route::post('attendances', [AttendanceController::class, 'store']);
  Route::get('attendances/{id}', [AttendanceController::class, 'show']);
  Route::put('attendances/{id}', [AttendanceController::class, 'update']);
  Route::delete('attendances/{id}', [AttendanceController::class, 'destroy']);
  // 出欠記録出力
  Route::post('outputs', [AttendanceController::class, 'output']);
});
