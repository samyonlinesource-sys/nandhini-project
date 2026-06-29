<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\SettingsModel;

class SettingsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'version' => 'required|string|max:255',
            'app_mode' => 'required|string|max:255',
            'maintenance_mode' => 'required|string|max:255',
        ]);

        $settings = SettingsModel::create([
            'version' => $request->version,
            'app_mode' => $request->app_mode,
            'maintenance_mode' => $request->maintenance_mode,
        ]);

        return response()->json(['message' => 'Settings created successfully', 'settings' => $settings], 201);
    }

    public function update(Request $request)
    {
        $settings = SettingsModel::find($request->id);

        if (!$settings) {
            return response()->json(['message' => 'Settings not found'], 404);
        }

        $request->validate([
            'version' => 'required|string|max:255',
            'app_mode' => 'required|string|max:255',
            'maintenance_mode' => 'required|string|max:255',
        ]);

        $settings->update([
            'version' => $request->version,
            'app_mode' => $request->app_mode,
            'maintenance_mode' => $request->maintenance_mode,
        ]);

        return response()->json(['message' => 'Settings updated successfully', 'settings' => $settings], 200);
    }

    public function settingsview(Request $request)
    {
       if ($request->filled('id')) {

            $setting = SettingsModel::find($request->id);

            if (!$setting) {
                return response()->json([
                    'status' => false,
                    'message' => 'Setting Not Found'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'data' => $setting
            ]);
        }

        $settings = SettingsModel::all();

        return response()->json([
            'status' => true,
            'data' => $settings
        ], 200);
    }
}
