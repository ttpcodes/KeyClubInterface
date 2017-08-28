<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        /* $user->id being empty means that the edit form was called from the
         * settings menu. In this case, we'd want to assign the user to the
         * currently authenticated user while checking for admin privileges.
         */
        if (!$user->id) {
            $user = Auth::user();
            if (Gate::allows('officer-actions')) {
                $homeLinks = Setting::firstOrCreate(['id' => 'homeLinks'], ['value' => null]);
                if ($homeLinks->value) {
                    $homeLinks = explode(',', $homeLinks->value);
                    print_r($homeLinks);
                    foreach($homeLinks as $urlPair) {
                        $urlPair = explode(',', $urlPair);
                    }
                }
                return view('settings', [
                    'user' => $user,
                    'homeLinks' => $homeLinks,
                    'organizationName' => Setting::firstOrCreate(['id' => 'organizationName'], ['value' => 'Key Club'])->value,
                ]);
            }
        }
        return view('settings', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        Setting::updateOrCreate(['id' => 'organizationName'], ['value' => $request->organizationName]);

        $newHomeLinks = '';
        for ($i = 0; $i < count($request->homeLinks); $i++) {
            if (!$request->homeLinks[$i] || !$request->homeLinkValues[$i]) {
                continue;
            }
            if ($newHomeLinks) {
                $newHomeLinks .= ",";
            }
            $newHomeLinks .= $request->homeLinks[$i] . ',' . $request->homeLinkValues[$i];
        }
        $homeLinks = Setting::updateOrCreate(['id' => 'homeLinks'], ['value' => $newHomeLinks]);

        if ($request->hasFile('bgImage')) {
            $path = $request->file('bgImage')->store('settings', 'public');
            // Setting::updateOrCreate(['id' => 'bgImage'], ['value' => $path]);
            $image = Setting::firstOrCreate(['id' => 'bgImage'], ['value' => null]);
            if ($image->value) {
                Storage::delete($image->value);
            }

            $image->value = $path;
            $image->save();
        }

        return [
            'status' => 'success',
            'settings' => Setting::all()
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
