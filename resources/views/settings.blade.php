@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">User Settings</div>
                <div class="panel-body">
                    @isset ($status['user'])
                        <div class="alert alert-success">
                            User information updated successfully!
                        </div>
                    @endisset
                    <p>These are the settings used for when you log into the application.</p>
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('users.update', $user->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
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
        </div>
    </div>
</div>
@endsection
