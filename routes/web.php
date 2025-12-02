<?php

use App\Http\Controllers\SensorController;
use App\Http\Controllers\ControlController;
use PhpMqtt\Client\Facades\MQTT;
use Illuminate\Support\Facades\Route;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
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
    
    Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [App\Http\Controllers\SettingsController::class, 'update'])->name('settings.update');
    
    Route::get('/control', [App\Http\Controllers\ControlController::class, 'index'])->name('control.index');
    Route::put('/control', [App\Http\Controllers\ControlController::class, 'update'])->name('control.update');

    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

// Halaman utama panel kontrol
Route::get('/', function () {
    $settings = session('settings', [
        'control_mode' => 'auto',
        'manual_pump_refill' => 0,
    ]);

    return view('control', compact('settings'));
})->name('control.panel');


// Simpan mode auto/manual + refill flag (tanpa MQTT)
Route::post('/control/save', function () {
    $settings = session('settings', []);

    $settings['control_mode'] = request('control_mode', 'auto');
    $settings['manual_pump_refill'] = request('manual_pump_refill', 0);

    session(['settings' => $settings]);

    return back()->with('success', 'System mode updated.');
})->name('control.save');


// Kirim MQTT ke ESP32 untuk kontrol pompa
Route::post('/pump/control', function () {
    $pump  = request('pump');   // pumpA / pumpB / refill
    $state = request('state');  // ON / OFF

    // Konfigurasi sesuai dengan ESP32 / HiveMQ
    $server   = 'c19cb715626944f6991e5ad93c7c93f2.s1.eu.hivemq.cloud';
    $port     = 8883;
    $clientId = 'laravel-panel-' . uniqid();

    $username = 'dendi';
    $password = 'Dendi123';

    $connectionSettings = (new ConnectionSettings)
        ->setUsername($username)
        ->setPassword($password)
        ->setUseTls(true)
        ->setTlsSelfSignedAllowed(true)
        ->setTlsVerifyPeer(false); // sama seperti espClient.setInsecure();

    $mqtt = new MqttClient($server, $port, $clientId);

    try {
        $mqtt->connect($connectionSettings, true);

        // publish ke topik sesuai ESP32
        $topic = "hydro/sistem1/control/{$pump}";
        $mqtt->publish($topic, $state, 0);

        $mqtt->disconnect();

        return back()->with('success', "Pump {$pump} set to {$state}");
    } catch (\Throwable $e) {
        return back()->with('success', 'Gagal kirim MQTT: ' . $e->getMessage());
    }
})->name('pump.control');

// API Routes (Unprotected for sensors)
Route::post('/api/sensors', [SensorController::class, 'store'])->name('api.sensors.store');
