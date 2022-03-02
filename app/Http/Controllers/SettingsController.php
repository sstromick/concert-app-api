<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Http\Requests\Setting\SettingStoreRequest;
use App\Http\Requests\Setting\SettingUpdateRequest;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::getFilteredSettings();
        return response()->json(['data' => $settings], 200);
    }

    public function noPaginate()
    {
        $settings = Setting::getFilteredSettings(true);
        return response()->json(['data' => $settings], 200);
    }

    public function store(SettingStoreRequest $request)
    {
        $attributes = $request->validated();
        $setting = Setting::create($attributes);
        return response()->json(['data' => $setting, 'message' => 'Setting created'], 201);
    }

    public function show(Setting $setting) {
        return response()->json(['data' => $setting], 200);
    }

    public function update(SettingUpdateRequest $request, Setting $setting) {
        $attributes = $request->validated();
        $setting->update($attributes);
        return response()->json(['data' => $setting, 'message' => 'Setting updated'], 200);
    }

    public function destroy(Setting $setting) {
        $setting->delete();
        return response()->json(['data' => $setting, 'message' => 'Setting deleted'], 200);
    }

}
