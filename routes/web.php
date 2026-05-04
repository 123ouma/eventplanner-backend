<?php

use Illuminate\Support\Facades\Route;

// AUTH
use App\Http\Controllers\AuthController;

// PUBLIC
use App\Http\Controllers\OB_EventController;
use App\Http\Controllers\OB_RegistrationController;

// ADMIN
use App\Http\Controllers\Admin\OB_EventController as AdminEventController;
use App\Http\Controllers\Admin\OB_CategoryController;
use App\Http\Controllers\Admin\OB_RegistrationController as AdminRegistrationController;
use App\Http\Controllers\Admin\OB_AdminDashboardController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', function () { return view('auth.forgot-password'); })->name('password.request');

/*
|--------------------------------------------------------------------------
| PUBLIC EVENTS
|--------------------------------------------------------------------------
*/
Route::get('/', [OB_EventController::class, 'index'])->name('home');

Route::get('/event/{id}', [OB_EventController::class, 'show'])
    ->name('event.show');

/*
|--------------------------------------------------------------------------
| USER REGISTRATIONS
|--------------------------------------------------------------------------
*/
Route::post('/registrations', [OB_RegistrationController::class, 'store'])
    ->middleware('auth')
    ->name('registrations.store');

Route::get('/my-registrations', [OB_RegistrationController::class, 'myRegistrations'])
    ->middleware('auth')
    ->name('registrations.my');

Route::delete('/registrations/{id}', [OB_RegistrationController::class, 'destroy'])
    ->middleware('auth')
    ->name('registrations.destroy');

/*
|--------------------------------------------------------------------------
| USER PROFILE
|--------------------------------------------------------------------------
*/
Route::get('/profile', [ProfileController::class, 'edit'])
    ->middleware('auth')
    ->name('profile.edit');

Route::put('/profile', [ProfileController::class, 'update'])
    ->middleware('auth')
    ->name('profile.update');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {

    Route::get('/dashboard', [OB_AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    // EVENTS
    Route::get('/events', [AdminEventController::class, 'index'])
        ->name('admin.events.index');

    Route::get('/events/create', [AdminEventController::class, 'create'])
        ->name('admin.events.create');

    Route::post('/events', [AdminEventController::class, 'store'])
        ->name('admin.events.store');

    Route::get('/events/{id}/edit', [AdminEventController::class, 'edit'])
        ->name('admin.events.edit');

    Route::put('/events/{id}', [AdminEventController::class, 'update'])
        ->name('admin.events.update');

    Route::delete('/events/{id}', [AdminEventController::class, 'destroy'])
        ->name('admin.events.delete');

    // CATEGORIES
    Route::get('/categories', [OB_CategoryController::class, 'index'])
        ->name('admin.categories.index');
        
        Route::get('/categories/create', [OB_CategoryController::class, 'create'])
    ->name('admin.categories.create'); 

    Route::post('/categories', [OB_CategoryController::class, 'store'])
        ->name('admin.categories.store');

    Route::delete('/categories/{id}', [OB_CategoryController::class, 'destroy'])
        ->name('admin.categories.delete');

    // REGISTRATIONS
    Route::get('/registrations', [AdminRegistrationController::class, 'index'])
        ->name('admin.registrations.index');

    Route::delete('/registrations/{id}', [AdminRegistrationController::class, 'destroy'])
        ->name('admin.registrations.delete');
});
