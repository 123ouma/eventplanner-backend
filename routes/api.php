<?php

use App\Http\Controllers\Api\Admin\OB_AdminCategoryApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OB_EventApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\OB_RegistrationApiController;
use App\Http\Controllers\Api\Admin\OB_AdminEventApiController;
use App\Http\Controllers\Api\Admin\OB_AdminRegistrationApiController;
use App\Http\Controllers\Api\Admin\OB_AdminDashboardApiController;

Route::get('/admin/dashboard', [OB_AdminDashboardApiController::class, 'index']);

Route::get('/admin/registrations', [OB_AdminRegistrationApiController::class, 'index']);
Route::delete('/admin/registrations/{id}', [OB_AdminRegistrationApiController::class, 'destroy']);

// Registration routes
Route::post('/reservations', [OB_RegistrationApiController::class, 'store']);
Route::get('/my-registrations/{userId}', [OB_RegistrationApiController::class, 'myRegistrations']);
Route::delete('/reservations/{id}', [OB_RegistrationApiController::class, 'destroy']);

// Auth routes
Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/logout', [AuthApiController::class, 'logout']);
Route::get('/me', [AuthApiController::class, 'me']);
Route::post('/profile/{id}', [AuthApiController::class, 'updateProfile']);
Route::post('/admin/login', [AuthApiController::class, 'adminLogin']);

// Public events routes
Route::get('/events', [OB_EventApiController::class, 'index']);
Route::get('/events/{id}', [OB_EventApiController::class, 'show']);

// Admin events routes
Route::get('/admin/events', [OB_AdminEventApiController::class, 'index']);
Route::get('/admin/events/{id}', [OB_AdminEventApiController::class, 'show']);
Route::post('/admin/events', [OB_AdminEventApiController::class, 'store']);
Route::put('/admin/events/{id}', [OB_AdminEventApiController::class, 'update']);
Route::delete('/admin/events/{id}', [OB_AdminEventApiController::class, 'destroy']);
Route::get('/admin/categories', [OB_AdminCategoryApiController::class, 'index']);
Route::post('/admin/categories', [OB_AdminCategoryApiController::class, 'store']);
Route::get('/admin/categories/{id}', [OB_AdminCategoryApiController::class, 'show']);
Route::put('/admin/categories/{id}', [OB_AdminCategoryApiController::class, 'update']);
Route::delete('/admin/categories/{id}', [OB_AdminCategoryApiController::class, 'destroy']);
