<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MemberController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view(Request $request)
    {
        return view('member', $request->user()->member);
    }

    public function isOfficer(Request $request)
    {
        abort_unless(Gate::allows('officer-actions'), 403);
        if(isset($request->user()->member->officer))
        {
            echo("lit");
        }
    }
}
