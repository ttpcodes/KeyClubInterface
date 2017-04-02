<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OfficerController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('officer');
    }

    public function view()
    {
        return view('admin/club');
    }
}
