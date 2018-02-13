<?php

namespace App\Services;

use App\Meeting;
use App\Member;
use App\MissingMember;
use App\Jobs\UpdateMeetingMembers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MeetingService
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Meeting::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Meeting
     */
    public function store(Request $request)
    {
        $this->authorize('create', Meeting::class);
        $this->validate($request, [
            'date_time' => 'required',
            'information' => 'required'
        ]);
        return Meeting::create([
            'date_time' => $request->date_time,
            'information' => $request->information
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Meeting  $meeting
     * @return \App\Meeting
     */
    public function update(Request $request, Meeting $meeting)
    {
        $this->authorize('update', $meeting);
        $response = [];
        if ($request->has('duplicate')) {
            \App\Jobs\RemoveMeetingDuplicateMembers::dispatch($meeting);
        } else {
            if ($request->has('members')) {
                UpdateMeetingMembers::dispatch($meeting, $request->input('members'));
                $response = array_merge($response, [
                    'members' => true
                ]);
            }
            if ($request->has('date_time')) {
                $this->validate($request, [
                    'date_time' => 'required',
                    'information' => 'required'
                ]);
                $meeting->date_time = $request->date_time;
                $meeting->information = $request->information;
                $meeting->save();
                $meeting->refresh();
            }
        }
        return $meeting;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Meeting  $meeting
     */
    public function destroy(Meeting $meeting)
    {
        $this->authorize('delete', $meeting);
        $meeting->delete();
    }
}
