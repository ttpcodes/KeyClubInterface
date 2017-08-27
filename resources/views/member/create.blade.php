@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Add Member</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('members.store') }}">
                        {{ csrf_field() }}

                        <text-input label="ID*" name="id" value="{{ old('id') }}" required
                            @if ($errors->has('id'))
                                error="{{$errors->first('id')}}"
                            @endif></text-input>
                        <text-input label="First Name*" name="first" value="{{ old('first') }}" required
                            @if ($errors->has('first'))
                                error="{{$errors->first('first')}}"
                            @endif></text-input>
                        <text-input label="Last Name*" name="last" value="{{ old('last') }}" required
                            @if ($errors->has('last'))
                                error="{{$errors->first('last')}}"
                            @endif></text-input>
                        <text-input label="Nickname" name="nickname" value="{{ old('nickname') }}"></text-input>
                        <text-input label="Suffix" name="suffix" value="{{ old('suffix') }}"></text-input>
                        <text-input label="Email*" name="email" value="{{ old('email') }}" required
                            @if ($errors->has('email'))
                                error="{{$errors->first('email')}}")
                            @endif> </text-input>
                        <text-input label="Address" name="address1" value="{{ old('address1') }}"></text-input>
                        <text-input label="Address 2" name="address2" value="{{ old('address2') }}"></text-input>
                        <text-input label="City" name="city" value="{{ old('city') }}"></text-input>
                        <text-input label="State" name="state" value="{{ old('state') }}"></text-input>
                        <text-input label="Country" name="country" value="{{ old('country') }}"></text-input>
                        <text-input label="ZIP Code" name="postal" value="{{ old('postal') }}"></text-input>
                        <text-input label="Graduation Year*" name="graduation" value="{{ old('graduation') }}" required
                            @if ($errors->has('graduation'))
                                error="{{$errors->first('graduation')}}"
                            @endif></text-input>
                        <text-input label="Phone Number*" name="phone" value="{{ old('phone') }}"
                            @if ($errors->has('phone'))
                                error="{{$errors->first('phone')}}"
                            @endif></text-input>
                        <date-input label="Birth Date" name="birth" value="{{ old('birth') }}"></date-input>
                        <text-input label="Gender" name="gender" value="{{ old('gender') }}"></text-input>
                        <text-input label="Secondary ID" name="secondary_id" value="{{ old('secondary_id') }}"></text-input>
                        <submit-button btn-style="btn-success" label="Create"></submit-button>
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
