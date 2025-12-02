<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class ControlController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->all();
        return view('control', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'control_mode' => 'required|in:auto,manual',
            'manual_water_pump' => 'required|in:0,1',
            'manual_nutrient_pump' => 'required|in:0,1',
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('control.index')->with('success', 'Control settings updated successfully');
    }
}
