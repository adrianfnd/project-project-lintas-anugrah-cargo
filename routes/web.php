<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OperatorAdminController;
use App\Http\Controllers\DriverAdminController;

use App\Http\Controllers\DashboardManagerOperasionalController;

use App\Http\Controllers\DashboardOperatorController;
use App\Http\Controllers\DriverOperatorController;
use App\Http\Controllers\PaketOperatorController;
use App\Http\Controllers\SuratJalanOperatorController;
use App\Http\Controllers\CheckpointOperatorController;
use App\Http\Controllers\MapTrackingOperatorController;
use App\Http\Controllers\RiwayatPaketOperatorController;

use App\Http\Controllers\ProfileDriverController;
use App\Http\Controllers\DriverDriverController;
use App\Http\Controllers\SuratJalanDriverController;
use App\Http\Controllers\MapTrackingDriverController;
use App\Http\Controllers\RiwayatPaketDriverController;

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

// Manager Operasional routes
Route::middleware(['auth', 'role:manager_operasional'])->prefix('manager-operasional')->group(function () {
    // Dashboard
    Route::get('dashboard', [DashboardManagerOperasionalController::class, 'dashboard'])->name('manager-operasional.dashboard');
    Route::get('/dashboard-manager-operasional/chart-paket', [DashboardManagerOperasionalController::class, 'getChartDataPaket'])->name('manager-operasional.chart.paket');
    Route::get('/dashboard-manager-operasional/chart-performance', [DashboardManagerOperasionalController::class, 'getChartDataPerformance'])->name('manager-operasional.chart.performance');
});

// Operator routes
Route::middleware(['auth', 'role:operator'])->prefix('operator')->group(function () {
        // Dashboard
        Route::get('dashboard', [DashboardOperatorController::class, 'dashboard'])->name('operator.dashboard');
        Route::get('/dashboard-operator/chart-paket', [DashboardOperatorController::class, 'getChartDataPaket'])->name('operator.chart.paket');
        Route::get('/dashboard-operator/chart-performance', [DashboardOperatorController::class, 'getChartDataPerformance'])->name('operator.chart.performance');

        // Driver
        Route::get('drivers', [DriverOperatorController::class, 'index'])->name('operator.driver.index');
        Route::get('drivers-detail-{id}', [DriverOperatorController::class, 'detail'])->name('operator.driver.detail');

        //Paket
        Route::get('pakets', [PaketOperatorController::class, 'index'])->name('operator.paket.index');
        Route::get('pakets-create', [PaketOperatorController::class, 'create'])->name('operator.paket.create');
        Route::get('pakets-detail-{id}', [PaketOperatorController::class, 'detail'])->name('operator.paket.detail');
        Route::post('pakets', [PaketOperatorController::class, 'store'])->name('operator.paket.store');
        Route::get('pakets-edit-{id}', [PaketOperatorController::class, 'edit'])->name('operator.paket.edit');
        Route::put('pakets-{id}', [PaketOperatorController::class, 'update'])->name('operator.paket.update');
        Route::delete('pakets-{id}', [PaketOperatorController::class, 'destroy'])->name('operator.paket.destroy');

        // Surat Jalan
        Route::get('suratjalans', [SuratJalanOperatorController::class, 'index'])->name('operator.suratjalan.index');
        Route::get('suratjalans-create', [SuratJalanOperatorController::class, 'create'])->name('operator.suratjalan.create');
        Route::get('suratjalans-detail-{id}', [SuratJalanOperatorController::class, 'detail'])->name('operator.suratjalan.detail');
        Route::post('suratjalans', [SuratJalanOperatorController::class, 'store'])->name('operator.suratjalan.store');
        Route::get('suratjalans-edit-{id}', [SuratJalanOperatorController::class, 'edit'])->name('operator.suratjalan.edit');
        Route::put('suratjalans-{id}', [SuratJalanOperatorController::class, 'update'])->name('operator.suratjalan.update');
        Route::delete('suratjalans-{id}', [SuratJalanOperatorController::class, 'destroy'])->name('operator.suratjalan.destroy');

        // Checkpoint
        Route::get('/checkpoints', [CheckpointOperatorController::class, 'index'])->name('operator.checkpoint.index');
        Route::post('/checkpoints', [CheckpointOperatorController::class, 'store'])->name('operator.checkpoint.store');
        Route::delete('/checkpoints/{checkpoint}', [CheckpointOperatorController::class, 'destroy'])->name('operator.checkpoint.destroy');

        // Map Tracking
        Route::get('/maptracking', [MaptrackingOperatorController::class, 'index'])->name('operator.maptracking.index');
        Route::get('/maptracking-detail-{id}', [MaptrackingOperatorController::class, 'detail'])->name('operator.maptracking.detail');

        // Riwayat Paket
        Route::get('riwayats', [RiwayatPaketOperatorController::class, 'index'])->name('operator.riwayat.index');
        Route::get('riwayats-detail-{id}', [RiwayatPaketOperatorController::class, 'detail'])->name('operator.riwayat.detail');
});

// Driver routes
Route::middleware(['auth', 'role:driver'])->prefix('driver')->group(function () {
    // Profile
    Route::get('profile', [ProfileDriverController::class, 'show'])->name('driver.profile.show');
    Route::post('profile', [ProfileDriverController::class, 'update'])->name('driver.profile.update');

    // Surat Jalan
    Route::middleware('driver_status:menunggu')->group(function () {
        Route::get('suratjalans', [SuratJalanDriverController::class, 'index'])->name('driver.suratjalan.index');
        Route::get('suratjalans-detail-{id}', [SuratJalanDriverController::class, 'detail'])->name('driver.suratjalan.detail');
        Route::get('suratjalans-antar-{id}', [SuratJalanDriverController::class, 'startDelivery'])->name('driver.suratjalan.antar');
    });

    // Map Tracking
    Route::middleware('driver_status:dalam perjalanan')->group(function () {
        Route::get('/maptracking-{id}', [MapTrackingDriverController::class, 'show'])->name('driver.maptracking.show');
        Route::post('/maptracking-cancel-{id}', [MapTrackingDriverController::class, 'cancel'])->name('driver.maptracking.cancel');
        Route::post('/maptracking-addcheckpoint-{id}', [MapTrackingDriverController::class, 'addCheckpoint'])->name('driver.maptracking.addcheckpoint');
        Route::post('/maptracking-finish-{id}', [MapTrackingDriverController::class, 'finish'])->name('driver.maptracking.finish');
    });

    // Riwayat Paket
    Route::get('riwayat', [RiwayatPaketDriverController::class, 'index'])->name('driver.riwayat.index');
    Route::get('riwayat-detail-{id}', [RiwayatPaketDriverController::class, 'detail'])->name('driver.riwayat.detail');
});
