<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use App\MissingMember;
use App\Member;
use App\Meeting;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $meetings = Meeting::all();
        return view('meeting/index', [
            'meetings' => $meetings
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('meeting/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Meeting::create([
            'date_time' => $request->date_time,
            'information' => $request->information
        ]);
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function show(Meeting $meeting)
    {
        return view('meeting/show', [
            'meeting' => $meeting
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function edit(Meeting $meeting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Meeting $meeting)
    {
        if ($request->has('members')) {
            $newMembers = array_diff($request->members, $meeting->members->modelKeys());
            $duplicate = array_diff($request->members, $newMembers);
            Log::info("Reduced " . count($request->members) . " to " . count($newMembers) . " new member entries");
            $members = Member::find($newMembers);
            Log::info($members->count() . " found out of " . count($newMembers));
            $missing = array_diff($newMembers, $members->modelKeys());
            $meeting->members()->saveMany($members);
        }
        if (count($missing) != 0) {
            $newMissing = array_diff($missing, $meeting->missing_members->modelKeys());
            $data = array();
            foreach ($newMissing as $id) {
                $data[] = array(
                    "id" => $id,
                    "meeting_id" => $meeting->id
                );
            }
            MissingMember::insert($data);
        }
        return [
            'status' => 'success',
            'missing' => $missing,
            'duplicate' => $duplicate
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meeting $meeting)
    {
        //
    }
}
