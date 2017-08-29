<?php

namespace App\Http\Controllers;

use App\Event;
use App\Officer;
use Illuminate\Http\Request;

class EventController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('officer');
    }

    public function manageEvent($id = null)
    {
        $event = Event::find(1);
        $officers = Officer::all();
        return view('admin/manageevent', ['event' => $event, 'officers' => $officers, 'id' => $id]);
    }

    public function updateEvent(Request $request, $id = null)
    {
        print_r($request->all());
    }
}
