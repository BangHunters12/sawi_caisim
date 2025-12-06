<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData; // Pastikan Anda punya model ini

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data terakhir untuk initial view
        $latest = SensorData::latest()->first();
        
        // Ambil history untuk grafik (misal 20 data terakhir)
        $history = SensorData::latest()->take(20)->get()->reverse()->values();

        return view('dashboard', compact('latest', 'history'));
    }
}