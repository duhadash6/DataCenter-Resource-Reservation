<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\ReservationAdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ResourceController as AdminResourceController;
use App\Http\Controllers\PublicResourceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('resources.public');
});

// ==================== PUBLIC ROUTES (GUESTS & AUTHENTICATED) ====================
Route::get('/resources/browse', [PublicResourceController::class, 'index'])->name('resources.public');
Route::get('/resources/view/{resource}', [PublicResourceController::class, 'show'])->name('resources.public.show');

// ==================== AUTH ROUTES ====================
// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Register
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ==================== RESOURCE ROUTES ====================
Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');
Route::get('/resources/{resource}', [ResourceController::class, 'show'])->name('resources.show');

// ==================== RESERVATION ROUTES (AUTHENTICATED) ====================
Route::middleware('auth')->group(function () {
    // Create reservation
    Route::get('/resources/{resource}/reserve', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/resources/{resource}/reserve', [ReservationController::class, 'store'])->name('reservations.store');

    // My reservations
    Route::get('/my-reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/my-reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::post('/my-reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');

    // Notifications
    Route::get('/notifications', function () {
        return view('notifications.index');
    })->name('notifications.index');
});

// ==================== ADMIN ROUTES ====================
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Resources management
    Route::get('/resources', [AdminResourceController::class, 'index'])->name('admin.resources.index');
    Route::post('/resources', [AdminResourceController::class, 'store'])->name('admin.resources.store');
    Route::post('/resources/{resource}/maintenance', [AdminResourceController::class, 'setMaintenance'])->name('admin.resources.maintenance');
    Route::post('/resources/{resource}/toggle-status', [AdminResourceController::class, 'toggleStatus'])->name('admin.resources.toggle-status');
    Route::delete('/resources/{resource}', [AdminResourceController::class, 'destroy'])->name('admin.resources.destroy');

    // Reservations management
    Route::get('/reservations', [ReservationAdminController::class, 'index'])->name('admin.reservations.index');
    Route::post('/reservations/{reservation}/approve', [ReservationAdminController::class, 'approve'])->name('admin.reservations.approve');
    Route::post('/reservations/{reservation}/reject', [ReservationAdminController::class, 'reject'])->name('admin.reservations.reject');

    // Statistics
    Route::get('/statistics', function () {
        return view('admin.statistics');
    })->name('admin.statistics');

    // Activity log
    Route::get('/activity-log', function () {
        return view('admin.activity-log');
    })->name('admin.activity-log');
});
