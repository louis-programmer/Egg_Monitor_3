<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $setting = Setting::first();

        return view('settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'preset_setter_survival_rate' => 'required|numeric|min:0|max:100',
            'preset_hatcher_survival_rate' => 'required|numeric|min:0|max:100',
            'preset_order_buffer' => 'required|numeric|min:0|max:100',
            'preset_setter_days' => 'required|integer|min:1',
            'preset_hatcher_days' => 'required|integer|min:1',
            'simulation_minutes_per_day' => 'required|integer|min:1',
        ]);

        $setting = Setting::first();

        $setting->update($validated);

        return redirect()
            ->route('settings.edit')
            ->with('success', 'Settings updated successfully.');
    }
}