<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        $settings = Setting::query()
            ->pluck('value', 'key');

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'app_name' => [
                'required',
                'string',
                'max:255',
            ],

            'app_description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'contact_email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'timezone' => [
                'required',
                'string',
                'timezone',
            ],

            'maintenance_mode' => [
                'nullable',
                'boolean',
            ],

            'theme_mode' => [
                'required',
                'in:light,dark,system',
            ],

            'logo_path' => [
                'nullable',
                'string',
                'max:500',
            ],

            'favicon_path' => [
                'nullable',
                'string',
                'max:500',
            ],
        ]);

        $validated['maintenance_mode'] = $request->boolean(
            'maintenance_mode'
        );

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()
            ->route('admin.settings.edit')
            ->with(
                'success',
                'Configuración actualizada correctamente.'
            );
    }
}
