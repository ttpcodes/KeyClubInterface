@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Create Meeting</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('meetings.store') }}">
                        {{ csrf_field() }}

                        <date-time label="Date & Time" name="date_time"></date-time>
                        <text-area label="Information" name="information"></text-area>

                        <submit-button btn-style="btn-success" label="Create"></submit-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
