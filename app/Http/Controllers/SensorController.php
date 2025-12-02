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

        $columns = ['Date', 'Time', 'Temperature (C)', 'Humidity (%)', 'Soil Moisture (%)', 'Light (%)', 'Water Level (cm)', 'TDS (ppm)', 'Water Pump', 'Nutrient Pump'];

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
                    $sensor->soil_moisture,
                    $sensor->light_intensity,
                    $sensor->water_level,
                    $sensor->tds_value,
                    $sensor->water_pump_status ? 'ON' : 'OFF',
                    $sensor->nutrient_pump_status ? 'ON' : 'OFF',
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
            'temperature' => 'required|numeric',
            'humidity' => 'required|numeric',
            'soil_moisture' => 'required|numeric',
            'light' => 'required|numeric',
            'water_level' => 'required|numeric',
            'tds_value' => 'required|numeric',
        ]);

        // Automation Logic
        $waterPumpStatus = false;
        $nutrientPumpStatus = false;

        // Get settings or use defaults
        $settings = \App\Models\Setting::pluck('value', 'key');
        $minWaterLevel = $settings['min_water_level'] ?? 10;
        $minSoilMoisture = $settings['min_soil_moisture'] ?? 40;
        $minTdsValue = $settings['min_tds_value'] ?? 600;
        $controlMode = $settings['control_mode'] ?? 'auto';

        // Safety: If water level is too low (< 10cm), everything OFF
        if ($data['water_level'] >= $minWaterLevel) {
            if ($controlMode === 'manual') {
                // Manual Mode: Use settings values
                $waterPumpStatus = ($settings['manual_water_pump'] ?? '0') == '1';
                $nutrientPumpStatus = ($settings['manual_nutrient_pump'] ?? '0') == '1';
            } else {
                // Auto Mode: Use sensor logic
                // Water Pump Logic: ON if dry (< threshold), OFF if wet (> threshold + 10 for hysteresis)
                if ($data['soil_moisture'] < $minSoilMoisture) {
                    $waterPumpStatus = true;
                }

                // Nutrient Pump Logic: ON if TDS low (< threshold), OFF if high
                if ($data['tds_value'] < $minTdsValue) {
                    $nutrientPumpStatus = true;
                }
            }
        }

        $sensor = Sensor::create(array_merge($data, [
            'water_pump_status' => $waterPumpStatus,
            'nutrient_pump_status' => $nutrientPumpStatus,
        ]));

        return response()->json([
            'message' => 'Data stored successfully',
            'data' => $sensor
        ]);
    }
}
