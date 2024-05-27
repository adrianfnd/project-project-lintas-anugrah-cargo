<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OperatorAdminController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Auth
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.action');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot.password');
Route::post('forgot-password', [AuthController::class, 'sendResetLink'])->name('forgot.password.post');

// Admin routes
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->group(function () {
    // Operator CRUD
    Route::get('operators', [OperatorAdminController::class, 'index'])->name('operator.index');
    Route::get('operators/create', [OperatorAdminController::class, 'create'])->name('operator.create');
    Route::post('operators', [OperatorAdminController::class, 'store'])->name('operator.store');
    Route::get('operators/{id}/edit', [OperatorAdminController::class, 'edit'])->name('operator.edit');
    Route::put('operators/{id}', [OperatorAdminController::class, 'update'])->name('operator.update');
    Route::delete('operators/{id}', [OperatorAdminController::class, 'destroy'])->name('operator.destroy');

    // Driver CRUD
    Route::get('drivers', [DriverAdminController::class, 'index'])->name('driver.index');
    Route::get('drivers/create', [DriverAdminController::class, 'create'])->name('driver.create');
    Route::post('drivers', [DriverAdminController::class, 'store'])->name('driver.store');
    Route::get('drivers/{id}/edit', [DriverAdminController::class, 'edit'])->name('driver.edit');
    Route::put('drivers/{id}', [DriverAdminController::class, 'update'])->name('driver.update');
    Route::delete('drivers/{id}', [DriverAdminController::class, 'destroy'])->name('driver.destroy');
});

// Operator routes
Route::middleware(['auth', 'role:Operator'])->prefix('operator')->group(function () {
});

// Driver routes
Route::middleware(['auth', 'role:Driver'])->prefix('driver')->group(function () {
});
