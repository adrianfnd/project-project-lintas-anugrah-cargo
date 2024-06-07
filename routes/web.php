<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\OperatorAdminController;
use App\Http\Controllers\DriverAdminController;

use App\Http\Controllers\PaketOperatorController;


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
    Route::get('dashboard', [DashboardAdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Operator
    Route::get('operators', [OperatorAdminController::class, 'index'])->name('admin.operator.index');
    Route::get('operators-create', [OperatorAdminController::class, 'create'])->name('admin.operator.create');
    Route::get('operators-detail-{id}', [OperatorAdminController::class, 'detail'])->name('admin.operator.detail');
    Route::post('operators', [OperatorAdminController::class, 'store'])->name('admin.operator.store');
    Route::get('operators-edit-{id}', [OperatorAdminController::class, 'edit'])->name('admin.operator.edit');
    Route::put('operators-{id}', [OperatorAdminController::class, 'update'])->name('admin.operator.update');
    Route::delete('operators-{id}', [OperatorAdminController::class, 'destroy'])->name('admin.operator.destroy');

    // Driver
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
    // Dashboard
    Route::get('dashboard', [OperatorController::class, 'dashboard'])->name('operator.dashboard');

    // Driver
    Route::get('drivers', [DriverOperatorController::class, 'index'])->name('operator.driver.index');
    Route::get('drivers-create', [DriverOperatorController::class, 'create'])->name('operator.driver.create');
    Route::get('drivers-detail-{id}', [DriverOperatorController::class, 'detail'])->name('operator.driver.detail');
    Route::post('drivers', [DriverOperatorController::class, 'store'])->name('operator.driver.store');
    Route::get('drivers-edit-{id}', [DriverOperatorController::class, 'edit'])->name('operator.driver.edit');
    Route::put('drivers-{id}', [DriverOperatorController::class, 'update'])->name('operator.driver.update');
    Route::delete('drivers-{id}', [DriverOperatorController::class, 'destroy'])->name('operator.driver.destroy');

    // Paket
    Route::get('pakets', [PaketOperatorController::class, 'index'])->name('operator.paket.index');
    Route::get('pakets-create', [PaketOperatorController::class, 'create'])->name('operator.paket.create');
    Route::get('pakets-detail-{id}', [PaketOperatorController::class, 'detail'])->name('operator.paket.detail');
    Route::post('pakets', [PaketOperatorController::class, 'store'])->name('operator.paket.store');
    Route::get('pakets-edit-{id}', [PaketOperatorController::class, 'edit'])->name('operator.paket.edit');
    Route::put('pakets-{id}', [PaketOperatorController::class, 'update'])->name('operator.paket.update');
    Route::delete('pakets-{id}', [PaketOperatorController::class, 'destroy'])->name('operator.paket.destroy');

    // Surat Jalan
    Route::get('suratjalans', [SuratJalanController::class, 'index'])->name('operator.suratjalan.index');
    Route::get('suratjalans-create', [SuratJalanController::class, 'create'])->name('operator.suratjalan.create');
    Route::get('suratjalans-detail-{id}', [SuratJalanController::class, 'detail'])->name('operator.suratjalan.detail');
    Route::post('suratjalans', [SuratJalanController::class, 'store'])->name('operator.suratjalan.store');
    Route::get('suratjalans-edit-{id}', [SuratJalanController::class, 'edit'])->name('operator.suratjalan.edit');
    Route::put('suratjalans-{id}', [SuratJalanController::class, 'update'])->name('operator.suratjalan.update');
    Route::delete('suratjalans-{id}', [SuratJalanController::class, 'destroy'])->name('operator.suratjalan.destroy');
});

// Driver routes
Route::middleware(['auth', 'role:driver'])->prefix('driver')->group(function () {
});
