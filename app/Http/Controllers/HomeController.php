<?php

namespace App\Http\Controllers;

use App\Setting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        $homeLinks = Setting::firstOrCreate(['id' => 'homeLinks'], ['value' => null]);
        $links = array();
        if ($homeLinks->value) {
            $homeLinks = explode(',', $homeLinks->value);
            for ($i = 0; $i < count($homeLinks); $i++) {
                if ($i % 2 == 0) {
                    $links[] = array($homeLinks[$i], $homeLinks[$i + 1]);
                }
            }
        }
        return view('welcome', [
            'organizationName' => Setting::firstOrCreate(['id' => 'organizationName'], ['value' => 'Key Club'])->value,
            'homeLinks' => $links,
            'imagePath' => Setting::firstOrCreate(['id' => 'bgImage'], ['value' => null])->value
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        if(!Auth::check()) {
            return redirect()->route('login');
        }
        return view('home');
    }
}
