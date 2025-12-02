<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        $defaults = [
            'min_soil_moisture' => '40',
            'min_tds_value' => '600',
            'min_water_level' => '10',
            'control_mode' => 'auto', // auto, manual
            'manual_water_pump' => '0', // 0, 1
            'manual_nutrient_pump' => '0', // 0, 1
        ];

        foreach ($defaults as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
