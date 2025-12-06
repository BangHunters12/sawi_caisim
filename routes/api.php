<?php
use App\Http\Controllers\Sensor;

Route::post('/sensors/store', [Sensor::class, 'store']);