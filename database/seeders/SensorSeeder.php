<?php

namespace Database\Seeders;

use App\Models\Sensor;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SensorSeeder extends Seeder
{
    public function run()
    {
        // Generate data for the last 24 hours (one reading per hour)
        $now = Carbon::now();
        
        for ($i = 23; $i >= 0; $i--) {
            Sensor::create([
                'temperature' => rand(240, 320) / 10, // 24.0 - 32.0
                'humidity' => rand(500, 800) / 10,    // 50.0 - 80.0
                'tds_value' => rand(500, 1200),       // 500 - 1200 ppm
                'ph' => rand(60, 80) / 10,            // 6.0 - 8.0
                'water_level' => rand(20, 100),       // 20 - 100 cm
                'pump_a_status' => rand(0, 1),
                'pump_b_status' => rand(0, 1),
                'refill_status' => rand(0, 1),
                'created_at' => $now->copy()->subHours($i),
                'updated_at' => $now->copy()->subHours($i),
            ]);
        }
    }
}
