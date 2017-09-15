<?php

namespace App\Services;

use App\Meeting;
use App\Member;
use App\MissingMember;

use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Facades\Log;

class MeetingService
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Meeting::all();
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
        $this->authorize('create', Meeting::class);
        $this->validate($request, [
            'date_time' => 'required',
            'information' => 'required'
        ]);
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
        $this->authorize('update', $meeting);
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
        $this->authorize('update', $meeting);
        Log::info('Processing meeting update.');
        if (count($request->all()) === 0) {
            Log::info('Received empty response. Returning 400.');
            return [
                'status' => 400,
                'error' => 'Empty request.'
            ];
        }
        $response = [];
        if ($request->has('meeting_json')) {
            Log::info('Found meeting_json attribute. Parsing.');
            if (!$request->has('members')) {
                $request->members = [];
            }
            $json = json_decode($request->input('meeting_json'));
            $request->members = array_merge($json->members, $request->members);
            $request->members = array_filter($request->members, function ($id) {
                return is_numeric($id);
            });
        }
        if ($request->has('members')) {
            Log::info('Found members attribute. Parsing.');
            // Removes all existing members from the array to leave new members.
            $newMembers = array_diff($request->members, $meeting->members->modelKeys());
            // Removes all new members from the array to leave duplicate members.
            $duplicate = array_diff($request->members, $newMembers);
            Log::info("Reduced " . count($request->members) . " to " . count($newMembers) . " new member entries");
            // Searches for new members where possible.
            $members = Member::find($newMembers);
            Log::info($members->count() . " found out of " . count($newMembers));

            $missing = array_diff($newMembers, $members->modelKeys(), $meeting->missing_members->modelKeys());
            $meeting->members()->saveMany($members);
            if (count($missing) != 0) {
                $data = array();
                foreach ($missing as $id) {
                    $data[] = array(
                        "id" => $id,
                        "meeting_id" => $meeting->id
                    );
                }
                $meeting->missing_members()->createMany($data);
                $meeting->refresh();
                $response = array_merge($response, [
                    'missing' => $meeting->missing_members->count()
                ]);
            }
            $meeting->refresh();
            $response = array_merge($response, [
                'duplicate' => $duplicate
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
        $response = array_merge($response, [
            'status' => 200,
            'meeting' => $meeting
        ]);
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meeting $meeting)
    {
        $this->authorize('delete', $meeting);
    }
}
