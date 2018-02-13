<?php

namespace App\Services;

use App\Member;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Validator;

class MemberService
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Member::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Member
     */
    public function store(Request $request)
    {
        $this->authorize('create', Member::class);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Member  $member
     * @return \App\Member
     */
    public function update(Request $request, Member $member)
    {
        $this->authorize('update', $member);

        $v = Validator::make($request->all(), [
            'id' => 'required',
            'first' => 'required',
            'last' => 'required'
        ]);
        $v->sometimes('id', 'unique:members', function ($input) use ($member) {
            return $input->id != $member->id;
        });
        $v->validate();

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
        $member->refresh();

        return $member;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Member  $member
     * @return int
     */
    public function destroy(Member $member)
    {
        $this->authorize('delete', $member);

        if (Auth::user()->member->id == $member->id) {
            return 403;
        }
        $member->delete();
        return 200;
    }
}
