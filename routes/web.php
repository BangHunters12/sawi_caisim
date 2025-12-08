<?php

use App\Http\Controllers\SensorController;
use App\Http\Controllers\ControlController;
use PhpMqtt\Client\Facades\MQTT;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PumpController;
// Public Routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'store'])->name('register.post');
// Route::put('/control/update', [ControlController::class, 'update'])
//     ->name('control.update');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [SensorController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [SensorController::class, 'analytics'])->name('analytics');
    Route::get('/analytics/export', [SensorController::class, 'export'])->name('analytics.export');
    
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    // Admin Only Routes
    Route::middleware(['admin'])->group(function () {
        Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
        Route::put('/settings', [App\Http\Controllers\SettingsController::class, 'update'])->name('settings.update');
        
        Route::get('/control', [App\Http\Controllers\ControlController::class, 'index'])->name('control.index');
        Route::put('/control', [App\Http\Controllers\ControlController::class, 'update'])->name('control.update');

        // Pump Control (Refactored)
        Route::get('/u', [PumpController::class, 'index'])->name('control.panel');
        Route::post('/control/save', [PumpController::class, 'saveSettings'])->name('control.save');
        Route::post('/pump/control', [PumpController::class, 'controlPump'])->name('pump.control');
    });
});

// API Routes (Unprotected for sensors)
Route::post('/api/sensors', [SensorController::class, 'store'])->name('api.sensors.store');
