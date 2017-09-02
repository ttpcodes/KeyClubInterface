<?php

namespace App\Services;

use App\Member;

class MemberService
{
    /**
     * Display a listing of the resource.
     *
     * @return \App\Member
     */
    public function index()
    {
        return Member::all();
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
        $this->validate($request, [
            'id' => 'required|unique:members',
            'first' => 'required',
            'last' => 'required'
        ]);
        return Member::create([
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        // 
    }
}
