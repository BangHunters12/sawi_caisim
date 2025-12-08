<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    public function index()
    {
        // Get the latest reading
        $latest = Sensor::latest()->first();

        // Get history for charts (last 24 readings, ordered by time)
        $history = Sensor::latest()->take(24)->get()->reverse()->values();

        return view('dashboard', compact('latest', 'history'));
    }

    public function analytics()
    {
        $sensors = Sensor::latest()->paginate(20);
        return view('analytics', compact('sensors'));
    }

    public function export()
    {
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=sensor_data.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Date', 'Time', 'Temperature (C)', 'Humidity (%)', 'TDS (ppm)', 'pH', 'Water Level (cm)', 'Pump A', 'Pump B', 'Refill'];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $sensors = \App\Models\Sensor::latest()->get();

            foreach ($sensors as $sensor) {
                $row = [
                    $sensor->created_at->format('Y-m-d'),
                    $sensor->created_at->format('H:i:s'),
                    $sensor->temperature,
                    $sensor->humidity,
                    $sensor->tds_value,
                    $sensor->ph,
                    $sensor->water_level,
                    $sensor->pump_a_status ? 'ON' : 'OFF',
                    $sensor->pump_b_status ? 'ON' : 'OFF',
                    $sensor->refill_status ? 'ON' : 'OFF',
                ];

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'temperature' => 'nullable|numeric',
            'humidity' => 'nullable|numeric',
            'tds_value' => 'nullable|numeric',
            'ph' => 'nullable|numeric',
            'water_level' => 'nullable|numeric',
            'pump_a_status' => 'boolean',
            'pump_b_status' => 'boolean',
            'refill_status' => 'boolean',
        ]);

        $sensor = Sensor::create($data);

        return response()->json([
            'message' => 'Data stored successfully',
            'data' => $sensor
        ]);
    }
}
