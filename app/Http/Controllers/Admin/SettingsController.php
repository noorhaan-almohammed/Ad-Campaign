<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::first();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'commission_rate' => 'nullable|numeric|min:0|max:100',
            'publisher_rate' => 'nullable|numeric|min:0|max:100',
            'minimum_withdraw' => 'nullable|numeric|min:0',
        ]);

        $settings = Setting::first();
        $settings->update($data);

        return back()->with('success', 'Settings updated successfully.');
    }
}
