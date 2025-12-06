<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData;

class SensorController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data yang masuk
        $validated = $request->validate([
            'temp' => 'numeric',
            'hum'  => 'numeric',
            'tds'  => 'numeric',
            'ph'   => 'numeric',
            'dist' => 'numeric',
            'pA'   => 'numeric',
            'pB'   => 'numeric',
            'pR'   => 'numeric',
        ]);

        // Simpan ke Database
        SensorData::create([
            'temperature' => $request->temp,
            'humidity'    => $request->hum,
            'tds_value'   => $request->tds,
            'ph'          => $request->ph,
            'water_level' => $request->dist,
            'pump_a_status' => $request->pA,
            'pump_b_status' => $request->pB,
            'refill_status' => $request->pR,
        ]);

        return response()->json(['message' => 'Data saved successfully'], 201);
    }
}