<?php

namespace App\Http\Controllers;

use App\Event;
use App\Member;
use App\Officer;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all();
        return view('event/index', ['events' => $events]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Event::class);
        return view('event/create', [
            'officers' => Officer::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Event::class);
        $this->validate($request, [
            'name' => 'required',
            'date' => 'required',
            'start' => 'required',
            'end' => 'required',
            'hours' => 'required',
            'officer_id' => 'required'
        ]);
        $event = Event::create([
            'name' => $request->name,
            'date' => $request->date,
            'start' => $request->start,
            'end' => $request->end,
            'hours' => $request->hours,
            'officer_id' => $request->officer_id
        ]);
        return [
            'status' => 'success',
            'event' => $event
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        $this->authorize('update', $event);
        return view('event/edit', [
            'event' => $event,
            'members' => Member::all(),
            'officers' => Officer::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);
        $this->validate($request, [
            'name' => 'required',
            'date' => 'required',
            'start' => 'required',
            'end' => 'required',
            'hours' => 'required',
            'officer_id' => 'required'
        ]);
        $event->name = $request->name;
        $event->date = $request->date;
        $event->start = $request->start;
        $event->end = $request->end;
        $event->hours = $request->hours;
        $event->officer_id = $request->officer_id;
        if (count(array_filter($request->members)) != 0) {
            $members = array_filter($request->members);
            $members = Member::find($members);
            $event->members()->saveMany($members);
        }
        $event->save();
        $event->load('members');
        return [
            'status' => 'success',
            'event' => $event
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);
    }
}
