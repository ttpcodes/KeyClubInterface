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
        $this->authorize('create', Member::class);
        $this->validate($request, [
            'id' => 'required|unique:members',
            'first' => 'required',
            'last' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'graduation' => 'required'
        ]);
        $member = Member::create([
            'id' => $request->id,
            'first' => $request->first,
            'last' => $request->last,
            'nickname' => $request->nickname,
            'suffix' => $request->suffix,
            'email' => $request->email,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'city' => $request->city,
            'country' => $request->country,
            'state' => $request->state,
            'postal'=> $request->postal,
            'graduation' => $request->graduation,
            'phone' => $request->phone,
            'birth' => $request->birth,
            'gender' => $request->gender,
            'secondary_id' => $request->secondary_id
        ]);

        return [ 'status' => 200, 'member' => $member ];
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
        $this->authorize('update', $member);
        Log::info($request->first);
        $v = Validator::make($request->all(), [
            'id' => 'required',
            'first' => 'required',
            'last' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'graduation' => 'required'
        ]);
        $v->sometimes('id', 'unique:members', function ($input) use ($member) {
            return $input->id != $member->id;
        });

        if ($v->fails()) {
            return back()
                    ->withErrors($v)
                    ->withInput();
        }

        $member->update([
            'id' => $request->id,
            'first' => $request->first,
            'last' => $request->last,
            'nickname' => $request->nickname,
            'suffix' => $request->suffix,
            'email' => $request->email,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'city' => $request->city,
            'country' => $request->country,
            'state' => $request->state,
            'postal'=> $request->postal,
            'graduation' => $request->graduation,
            'phone' => $request->phone,
            'birth' => $request->birth,
            'gender' => $request->gender,
            'secondary_id' => $request->secondary_id
        ]);

        $member->save();

        return view('member.show', [
            'status' => 200,
            'member' => $member
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
        $this->authorize('delete', $member);

        if (Auth::user()->member->id == $member->id) {
            return back()->with('status', 403)->with('type', 'self');
        }

        $member->delete();
        return back()->with('status', 200)->with('type', 'delete');
    }
}
