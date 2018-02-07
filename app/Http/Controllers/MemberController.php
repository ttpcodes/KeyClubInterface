<?php

namespace App\Http\Controllers;

use App\Member;
use App\Services\MemberService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    protected $members;

    public function __construct(MemberService $members) {
        $this->middleware('auth');
        $this->members = $members;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = $this->members->index();
        return view('member/index', [
            'members' => $members
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Member::class);
        return view('member/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $member = $this->members->store($request);

        return view('member.index', [
            'status' => 200,
            'member' => $member,
            'members' => Member::all()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        return view('member.show', [
            'member' => $member
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        $this->authorize('update', $member);
        return view('member.edit', [
            'member' => $member
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        $response = $this->members->update($request, $member);
        return view('member.show', [
            'member' => $response['member']
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        $response = $this->members->destroy($member);
        if ($response['status'] === 403) {
            return back()->with('status', 403)->with('type', 'self');
        } else {
            return back()->with('status', 200)->with('type', 'delete');
        }
    }
}
