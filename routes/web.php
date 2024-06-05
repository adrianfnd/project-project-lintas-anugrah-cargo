<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OperatorAdminController;
use App\Http\Controllers\DriverAdminController;


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

Route::get('/', function () {
    return view('auth.login');
});

// Auth
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.action');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot.password');
Route::post('forgot-password', [AuthController::class, 'sendResetLink'])->name('forgot.password.post');

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Operator CRUD
    Route::get('operators', [OperatorAdminController::class, 'index'])->name('admin.operator.index');
    Route::get('operators-create', [OperatorAdminController::class, 'create'])->name('admin.operator.create');
    Route::get('operators-detail-{id}', [OperatorAdminController::class, 'detail'])->name('admin.operator.detail');
    Route::post('operators', [OperatorAdminController::class, 'store'])->name('admin.operator.store');
    Route::get('operators-edit-{id}', [OperatorAdminController::class, 'edit'])->name('admin.operator.edit');
    Route::put('operators-{id}', [OperatorAdminController::class, 'update'])->name('admin.operator.update');
    Route::delete('operators-{id}', [OperatorAdminController::class, 'destroy'])->name('admin.operator.destroy');

    // Driver CRUD
    Route::get('drivers', [DriverAdminController::class, 'index'])->name('admin.driver.index');
    Route::get('drivers-create', [DriverAdminController::class, 'create'])->name('admin.driver.create');
    Route::get('drivers-detail-{id}', [DriverAdminController::class, 'detail'])->name('admin.driver.detail');
    Route::post('drivers', [DriverAdminController::class, 'store'])->name('admin.driver.store');
    Route::get('drivers-edit-{id}', [DriverAdminController::class, 'edit'])->name('admin.driver.edit');
    Route::put('drivers-{id}', [DriverAdminController::class, 'update'])->name('admin.driver.update');
    Route::delete('drivers-{id}', [DriverAdminController::class, 'destroy'])->name('admin.driver.destroy');
});

// Operator routes
Route::middleware(['auth', 'role:operator'])->prefix('operator')->group(function () {
});

// Driver routes
Route::middleware(['auth', 'role:driver'])->prefix('driver')->group(function () {
});
