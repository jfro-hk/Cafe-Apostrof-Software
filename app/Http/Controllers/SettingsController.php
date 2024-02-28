<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function getSettings(){
        $settings = Setting::first();
    }
    public function update(Request $request,$id) {
//        dd($request->all());

        $request->validate([
            'video' => 'required|string',
            'total_tables' => 'required|integer',
        ]);

        if ($id) {
            $settings = Setting::find($id);
            // Update the existing record
            $settings->update([
                'video' => $request->video,
                'total_tables' => $request->total_tables
            ]);
            return back()->with('success', 'Settings updated successfully!');
        } else {
            Setting::create([
                'video' => $request->video,
                'total_tables' => $request->total_tables
            ]);
        }
    }


}
