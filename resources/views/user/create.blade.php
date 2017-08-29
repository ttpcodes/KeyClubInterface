@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Create User</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('users.store') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-md-4 control-label">Member</label>
                            <div class="col-md-6">
                                <input name="member_id" type="text" class="form-control" autofocus list='datalist' required>
                            </div>
                        </div>
                        <datalist id="datalist">
                        @foreach ($members as $member)
                            <option value="{{ $member->id }}">{{ $member->id.' - '.$member->first.' '.$member->last }}</option>
                        @endforeach
                        </datalist>
                        <text-input label="Email Address" name="email"></text-input>
                        <password-input hint="Leave blank for random password" label="Password" name="password"></password-input>
                        <submit-button btn-style="btn-success" label="Create"></submit-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
