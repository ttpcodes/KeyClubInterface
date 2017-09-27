<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MeetingTableController extends Controller
{
    public function __invoke(Request $request) {
        $index = $request->query('index', 1);
        $count = $request->query('count', 10);

        return view('meeting.table', [
            'meetings' => \App\Meeting::where('id', '>=', $index)
                    ->take($count)
                    ->get(),
            'members' => \App\Member::all()
        ]);
    }
}
