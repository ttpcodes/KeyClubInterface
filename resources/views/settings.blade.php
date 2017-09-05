@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">User Settings</div>
                <div class="panel-body">
                    @if (Session::get('status') == '200-user')
                        <div class="alert alert-success">
                            User information updated successfully!
                        </div>
                    @endisset
                    <p>These are the settings used for when you log into the application.</p>
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('users.update', $user->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <input type="hidden" name="settings" value="true">
                        <text-input label="Email" name="email" required
                            value="{{ $errors->has('email') ? old('email') : $user->email }}"
                            @if ($errors->has('email'))
                                error="{{$errors->first('email')}}"
                            @endif></text-input>
                        <password-input label="Password" name="password" hint="Leave blank to remain unchanged"></password-input>
                        <submit-button btn-style="btn-primary" label="Update"></submit-button>
                    </form>
                </div>
            </div>
            @if (Gate::allows('officer-actions'))
            <div class="panel panel-default">
                <div class="panel-heading">Application Settings</div>
                <div class="panel-body">
                    @if (Session::get('status') == '200-settings')
                        <div class="alert alert-success">
                            Settings updated successfully!
                        </div>
                    @endisset
                    <p>These are the settings used for what every user sees on the website.</p>
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('settings.update') }}"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <text-input label="Organization Name" name="organizationName" required
                            value="{{ $errors->has('organizationName') ? old('organizationName') : $organizationName }}">
                        </text-input>
                        <text-input-group values="{{ $homeLinks }}">
                        </text-input-group>
                        <file-input label="New Background Picture" name="bgImage"></file-input>
                        <submit-button btn-style="btn-primary" label="Update"></submit-button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
