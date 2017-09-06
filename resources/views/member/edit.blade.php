@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Add Member</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('members.update', $member->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <text-input label="ID*" name="id" value="{{ $errors->has('id') ? old('id') : $member->id }}" required
                            @if ($errors->has('id'))
                                error="{{$errors->first('id')}}"
                            @endif></text-input>
                        <text-input label="First Name*" name="first" value="{{ $errors->has('first') ? old('first') : $member->first }}" required
                            @if ($errors->has('first'))
                                error="{{$errors->first('first')}}"
                            @endif></text-input>
                        <text-input label="Last Name*" name="last" value="{{ $errors->has('last') ? old('last') : $member->last }}" required
                            @if ($errors->has('last'))
                                error="{{$errors->first('last')}}"
                            @endif></text-input>
                        <text-input label="Nickname" name="nickname" value="{{ $errors->has('nickname') ? old('nickname') : $member->nickname }}"></text-input>
                        <text-input label="Suffix" name="suffix" value="{{ $errors->has('suffix') ? old('suffix') : $member->suffix }}"></text-input>
                        <text-input label="Email*" name="email" value="{{ $errors->has('email') ? old('email') : $member->email }}" required
                            @if ($errors->has('email'))
                                error="{{$errors->first('email')}}")
                            @endif> </text-input>
                        <text-input label="Address" name="address1" value="{{ $errors->has('address1') ? old('address1') : $member->address1 }}"></text-input>
                        <text-input label="Address 2" name="address2" value="{{ $errors->has('address2') ? old('address2') : $member->address2 }}"></text-input>
                        <text-input label="City" name="city" value="{{ $errors->has('city') ? old('city') : $member->city }}"></text-input>
                        <text-input label="State" name="state" value="{{ $errors->has('state') ? old('state') : $member->state }}"></text-input>
                        <text-input label="Country" name="country" value="{{ $errors->has('country') ? old('country') : $member->country }}"></text-input>
                        <text-input label="ZIP Code" name="postal" value="{{ $errors->has('postal') ? old('postal') : $member->postal }}"></text-input>
                        <text-input label="Graduation Year*" name="graduation" value="{{ $errors->has('graduation') ? old('graduation') : $member->graduation }}" required
                            @if ($errors->has('graduation'))
                                error="{{$errors->first('graduation')}}"
                            @endif></text-input>
                        <text-input label="Phone Number*" name="phone" value="{{ $errors->has('phone') ? old('phone') : $member->phone }}"
                            @if ($errors->has('phone'))
                                error="{{$errors->first('phone')}}"
                            @endif></text-input>
                        <date-input label="Birth Date" name="birth" value="{{ $errors->has('birth') ? old('birth') : $member->birth }}"></date-input>
                        <text-input label="Gender" name="gender" value="{{ $errors->has('gender') ? old('gender') : $member->gender }}"></text-input>
                        <text-input label="Secondary ID" name="secondary_id" value="{{ $errors->has('secondary_id') ? old('secondary_id') : $member->secondary_id }}"></text-input>
                        <submit-button btn-style="btn-primary" label="Update"></submit-button>
                        <div class="col-md-offset-4 col-md-8">
                            <strong style="color: red;">* = Required</strong>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
