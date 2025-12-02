<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->all();
        return view('settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'min_soil_moisture' => 'required|numeric|min:0|max:100',
            'min_tds_value' => 'required|numeric|min:0',
            'min_water_level' => 'required|numeric|min:0|max:100',
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully');
    }
}
