<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function GetSettingsBySlug(Request $request, $slug)
    {
        $settings = Setting::where('slug', $slug)->first();
        return view('admin.settings.'.$slug.'.index', compact('settings'));
    }

    public function EditSettingsBySlug($slug)
    {
        $settings = Setting::where('slug', $slug)->first();
        return view('admin.settings.tickets.edit', 
            compact(
                'settings'
            )
        );
    }

    public function UpdateSettingsBySlug(Request $request, $slug)
    {
        $settings = Setting::where('slug', $slug)->first();
        $settings->update([
            'body' => '{"title": "'.$request->title.'","value": '.$request->value.'}',
            'active' => $request->active
        ]);
        return view('admin.settings.'.$slug.'.index', compact('settings'));
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
