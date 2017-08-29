<?php

namespace App\Http\Controllers;

use App\Member;
use App\Setting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user/create', [
            'members' => Member::all()
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
        $this->validate($request, [
            'member_id' => 'required',
            'email' => 'nullable|email',
            'password' => 'nullable'
        ]);

        $member = Member::find($request->member_id);
        $email = $member->email;
        $password = Str::random();

        if ($request->has('email')) {
            $email = $request->email;
        }
        if ($request->has('password')) {
            $password = $request->password;
        }

        $user = User::create([
            'name' => $member->first . ' ' . $member->last,
            'email' => $email,
            'password' => Hash::make($password)
        ]);
        $member->user()->associate($user);
        $member->save();

        return [
            'status' => 'success',
            'user' => $user,
            'password' => $password
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        /* $user->id being empty means that the edit form was called from the
         * settings menu. In this case, we'd want to assign the user to the
         * currently authenticated user while checking for admin privileges.
         */
        if (!$user->id) {
            $user = Auth::user();
            if (Gate::allows('officer-actions')) {
                $homeLinks = Setting::firstOrCreate(['id' => 'homeLinks'], ['value' => null]);
                // if ($homeLinks->value) {
                //     $links = array();
                //     $homeLinks = explode(',', $homeLinks->value);
                //     for ($i = 0; $i < count($homeLinks); $i++) {
                //         if ($i % 2 == 0) {
                //             $links[] = array($homeLinks[$i], $homeLinks[$i + 1]);
                //         }
                //     }
                // }
                return view('settings', [
                    'user' => $user,
                    'homeLinks' => Setting::firstOrCreate(['id' => 'homeLinks'], ['value' => null])->value,
                    'organizationName' => Setting::firstOrCreate(['id' => 'organizationName'], ['value' => 'Key Club'])->value,
                ]);
            }
        }
        return view('settings', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $v = Validator::make($request->all(), [
            'email' => 'required'
        ]);
        $v->sometimes('email', 'unique', function ($input) use ($user) {
            return $input->email != $user->email;
        });
        $user->email = $request->email;
        if (strlen($request->password) != 0) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return view('settings', [
            "status" => [
                "user" => "success"
            ],
            "user" => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
